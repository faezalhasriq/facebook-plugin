<?php

/**
 * @author Emil Kilhage
 */
class FacebookLicenseValidator
{
    const KEY_VALID_UNTIL = 'valid_until';
    const KEY_NUMBER_OF_USERS = 'number_of_users';
    const KEY_LICENSE = 'license_key';
    const KEY_APPLICATION = 'application';

    /**
     * @var string
     */
    private $labelName = 'FACEBOOK_DASHLET';

    /**
     * @var string
     */
    private $licenseAboutToExpireWarningInterval = '- 2 weeks';

    /**
     * @var string
     */
    private $notificationInterval = '- 2 days';

    /**
     * @var \DBManager
     */
    private $db;

    /**
     * @var \TimeDate
     */
    private $timeDate;

    /**
     * @var array
     */
    private $requiredKeys = array (
        self::KEY_LICENSE,
        self::KEY_APPLICATION,
        self::KEY_VALID_UNTIL,
    );

    /**
     * LicenseValidator constructor.
     */
    public function __construct()
    {
        $this->db = \DBManagerFactory::getInstance();
        $this->timeDate = \TimeDate::getInstance();
    }

    /**
     * @param string $application
     * @param string $licenseKey
     * @param string $validationKey
     *
     * @return bool
     */
    public function validateKey($application, $licenseKey, $validationKey)
    {
        $validationKey = $this->decrypt($validationKey);
        $this->checkValidationKey($validationKey);
        $this->checkLicenseKey($validationKey, $licenseKey);
        $this->checkApplication($validationKey, $application);
        $this->checkExpired($validationKey);
        $this->checkUserLimit($validationKey);
        $this->checkAboutToExpire($validationKey);
    }

    /**
     * @param array $validationKey
     *
     * @param string $licenseKey
     *
     * @throws \SugarApiException
     */
    private function checkLicenseKey(array $validationKey, $licenseKey)
    {
        if ($licenseKey !== $validationKey[self::KEY_LICENSE]) {
            $this->throwError();
        }
    }

    /**
     * @param array $validationKey
     * @param string $application
     */
    private function checkApplication(array $validationKey, $application)
    {
        if ($application !== $validationKey[self::KEY_APPLICATION]) {
            $this->throwError();
        }
    }

    /**
     * @param array $validationKey
     */
    private function checkUserLimit(array $validationKey)
    {
        $currentNumberOfUsers = $this->getCurrentNumberOfUsers();
        $userLimit = $this->getUserLimit($validationKey);

        if ($currentNumberOfUsers > $userLimit && $userLimit !== "") {
            $this->createNotification(
                translate($this->createLabel('USER_LIMIT_REACHED_NAME')),
                string_format(
                    translate($this->createLabel('USER_LIMIT_REACHED_DESCRIPTION')),
                    array ($userLimit)
                )
            );
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function createLabel($name)
    {
        return 'LBL_' . $this->labelName . '_' . $name;
    }

    /**
     * @param array $validationKey
     */
    private function checkAboutToExpire(array $validationKey)
    {
        $now = $this->getNow();
        $validUntil = $this->getValidUntil($validationKey);
        $licenseAboutToExpireWarning = $this->getLicenseAboutToExpireWarningDate($validationKey);

        if ($now->getTimestamp() > $licenseAboutToExpireWarning->getTimestamp()) {
            $this->createNotification(
                translate($this->createLabel('LICENSE_ABOUT_TO_EXPIRE_NAME')),
                string_format(
                    translate($this->createLabel('LICENSE_ABOUT_TO_EXPIRE_DESCRIPTION')),
                    array ($this->timeDate->asUserDate($validUntil))
                )
            );
        }
    }

    /**
     * @param $validationKey
     *
     * @return \DateTime
     */
    private function getLicenseAboutToExpireWarningDate($validationKey)
    {
        $licenseAboutToExpireWarning = $this->getValidUntil($validationKey);
        $licenseAboutToExpireWarning->modify($this->licenseAboutToExpireWarningInterval);
        return $licenseAboutToExpireWarning;
    }

    /**
     * @return \DateTime
     */
    private function getNotificationDate()
    {
        $notificationDate = $this->timeDate->getNow();
        $notificationDate->modify($this->notificationInterval);
        return $notificationDate;
    }

    /**
     * @param string $name
     * @param string $description
     */
    private function createNotification($name, $description)
    {
        $notificationDate = $this->getNotificationDate();

        foreach ($this->getAdminUserIds() as $userId) {
            $sql = <<<SQL
              SELECT id
              FROM notifications
              WHERE assigned_user_id = '%s'
                AND name = '%s'
                AND deleted = 0
                AND date_entered >= '%s'
SQL;
            $sql = sprintf($sql, $userId, $name, $this->timeDate->asDb($notificationDate));

            $notificationId = $this->db->getOne($sql, true);

            if (empty($notificationId)) {
                /** @var \Notifications $notification */
                $notification = \BeanFactory::newBean('Notifications');
                $notification->name = $name;
                $notification->description = $description;
                $notification->assigned_user_id = $userId;
                $notification->severity = 'warning';
                $notification->save();
            }
        }
    }

    /**
     * @return array
     */
    private function getAdminUserIds()
    {
        $sql = <<<SQL
            SELECT id
            FROM users u
            WHERE u.is_admin = 1
              AND u.deleted = 0
SQL;

        $ids = array ();

        $result = \DBManagerFactory::getInstance()->query($sql, true);

        while ($row = $this->db->fetchByAssoc($result)) {
            $ids[] = $row['id'];
        }

        return $ids;
    }

    /**
     * @param string $validationKey
     *
     * @return array
     */
    private function decrypt($validationKey)
    {
        $validationKey = base64_decode($validationKey);

        if (empty($validationKey)) {
            $this->throwError();
        }

        $validationKey = unserialize($validationKey);

        if (!is_array($validationKey)) {
            $this->throwError();
        }

        return $validationKey;
    }

    /**
     * @throws \SugarApiException
     */
    private function throwError()
    {
        $e = new \SugarApiException(
            'ERROR_INVALID_LICENSE',
            array (),
            'Cases',
            403
        );

        throw $e;
    }

    /**
     * @param array $validationKey
     *
     * @return bool
     */
    private function checkExpired(array $validationKey)
    {
        $now = $this->getNow();
        $validUntil = $this->getValidUntil($validationKey);

        if ($now->getTimestamp() > $validUntil->getTimestamp()) {
            $this->throwError();
        }
    }

    /**
     * @param array $validationKey
     *
     * @throws \SugarApiException
     */
    private function checkValidationKey(array $validationKey)
    {
        foreach ($this->requiredKeys as $index) {
            if (empty($validationKey[$index])) {
                $this->throwError();
            }
        }
    }

    /**
     * @return \DateTime
     */
    private function getNow()
    {
        $now = $this->timeDate->getNow();
        $now->setTime(0, 0, 0);

        return $now;
    }

    /**
     * @param array $validationKey
     *
     * @return \DateTime
     */
    private function getValidUntil(array $validationKey)
    {
        $validUntil = $this->timeDate->fromDbDate($validationKey[self::KEY_VALID_UNTIL]);
        $validUntil->setTime(0, 0, 0);

        return $validUntil;
    }

    /**
     * @return int
     */
    private function getCurrentNumberOfUsers()
    {
        $sql = <<<SQL
            SELECT count(u.id)
            FROM users u
            WHERE u.deleted = 0
              AND u.status = 'Active'
SQL;

        $currentNumberOfUsers = $this->db->getOne($sql, true);

        return $currentNumberOfUsers;
    }

    /**
     * @param array $validationKey
     *
     * @return mixed
     */
    private function getUserLimit(array $validationKey)
    {
        $userLimit = isset($validationKey[self::KEY_NUMBER_OF_USERS]) ? $validationKey[self::KEY_NUMBER_OF_USERS] : "";

        return $userLimit;
    }
}
