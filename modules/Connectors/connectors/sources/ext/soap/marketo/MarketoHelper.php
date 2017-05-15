<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/
require_once('include/SugarFields/SugarFieldHandler.php');
require_once('include/externalAPI/Marketo/MarketoFactory.php');
require_once('include/connectors/utils/ConnectorUtils.php');
require_once('modules/DynamicFields/FieldCases.php');

class MarketoHelper
{

    public static function getObjectName(SugarBean $bean)
    {
        switch (strtolower($bean->getObjectName())) {
            case 'lead':
            case 'leads':
                return 'Leads';
            case 'contact':
            case 'contacts':
                return 'Contacts';
            case 'account':
            case 'accounts':
                return 'Accounts';
            case "employee":
            case "employees":
            case 'user':
            case 'users':
                return 'Users';
            default:
                return ucwords(strtolower($bean->getObjectName()));
        }
    }

    /**
     * Marketo requires a complex set of functionality. We need to make sure that everything is setup correctly.
     */
    public static function ValidateInstallation()
    {

        global $sugar_version;
        self::addSchedulers();

        $marketoCustomFields = array(
            'sugarcrm_type',
            'sugarcrm_id',
            'sugarcrm_owner_first_name',
            'sugarcrm_owner_last_name',
            'sugarcrm_owner_title',
            'sugarcrm_owner_phone',
            'sugarcrm_owner_email',
            'sugarcrm_deleted'
        );

        $missingCustomFields = array();

        //check for custom fields in marketo
        foreach ($marketoCustomFields as $customField) {
            $field = MarketoFactory::getInstance(false, MarketoFactory::MARKETO)->getFieldsWithParams(
                'marketo',
                $customField
            );
            if (empty($field)) {
                $missingCustomFields[] = $customField;
            }
        }

        if (!empty($missingCustomFields)) {
            throw new Exception("The following custom api fields are required and need to be added Marketo: " . implode(
                    ", ",
                    $missingCustomFields
                ));
        }

        self::addMarketoCustomFields();

        if (version_compare($sugar_version, '7.1.5') < 0) {
            self::addFieldToSugar6Screens();
        } else {
            self::addFieldToScreens();
        }
    }

    /**
     * Marketo requires a complex set of functionality.
     * We need to make sure that everything is deleted correctly after deleting Marketo.
     * @throws SugarQueryException
     */
    public static function validateDeleting()
    {
        self::deleteSchedulers();
    }

    public static function addMarketoCustomFields()
    {
        require_once('modules/ModuleBuilder/controller.php');
        $beanTypes = array('Leads', 'Contacts', 'Opportunities');
        foreach ($beanTypes as $type) {
            $bean = BeanFactory::getBean($type);

            foreach (self::getCustomFields($type) as $field => $fieldDefinition) {
                if ($bean->custom_fields->fieldExists($field) == false) {

                    unset($fieldDefinition['id']);
                    $fieldDefinition['view_module'] = $fieldDefinition['module'];
                    $fieldDefinition['module'] = 'ModuleBuilder';

                    $mbc = new ModuleBuilderController();
                    $_REQUEST = $fieldDefinition;
                    $mbc->action_SaveField();
                }
            }
        }

        $customFields = self::getCustomOpportunitiesFields();
        self::addCustomFieldProperties($customFields['mrkto2_is_won_c'], array('readonly' => 'true'));
        self::addCustomFieldProperties($customFields['mrkto2_is_closed_c'], array('readonly' => 'true'));

        VardefManager::refreshVardefs('Opportunities', 'Opportunity');
        VardefManager::refreshVardefs('Leads', 'Lead');
        VardefManager::refreshVardefs('Contacts', 'Contact');
    }

    /**
     * This function will add the needed Marketo Schedulers to SugarCRM; We only want to add the schedulers if they don't
     * already exist
     */
    public static function addSchedulers()
    {
        $dt = new DateTime('now', new DateTimeZone('UTC'));

        $scheduler = BeanFactory::getBean("Schedulers");
        $scheduler->retrieve_by_string_fields(array('job' => 'function::marketoSync'));

        if (empty($scheduler->id)) {
            $scheduler->name = 'Check Marketo for changes to Leads';
            $scheduler->job = 'function::marketoSync';
            $scheduler->date_time_start = $dt->format(TimeDate::DB_DATETIME_FORMAT);
            $scheduler->date_time_end = '2099-01-01 23:59:59';
            $scheduler->job_interval = '*/5::*::*::*::*';
            $scheduler->created_by = '1';
            $scheduler->modified_user_id = '1';
            $scheduler->status = 'Inactive';
            $scheduler->catch_up = '1';
            $scheduler->save();
        }

        $scheduler = BeanFactory::getBean("Schedulers");
        $scheduler->retrieve_by_string_fields(array('job' => 'function::marketoActivityLogSync'));
        if (empty($scheduler->id)) {
            $scheduler->name = 'Check for Marketo for updates to Activity Logs';
            $scheduler->job = 'function::marketoActivityLogSync';
            $scheduler->date_time_start = $dt->format(TimeDate::DB_DATETIME_FORMAT);
            $scheduler->date_time_end = '2099-01-01 23:59:59';
            $scheduler->job_interval = "*/30::*::*::*::*";
            $scheduler->created_by = '1';
            $scheduler->modified_user_id = '1';
            $scheduler->status = 'Inactive';
            $scheduler->catch_up = '1';
            $scheduler->save();
        }

        $scheduler = BeanFactory::getBean("Schedulers");
        $scheduler->retrieve_by_string_fields(array('job' => 'function::marketoPurgeOldJobs'));
        if (empty($scheduler->id)) {
            $scheduler->name = 'Purge old deleted records from Marketo queue table.';
            $scheduler->job = 'function::marketoPurgeOldJobs';
            $scheduler->date_time_start = $dt->format(TimeDate::DB_DATETIME_FORMAT);
            $scheduler->date_time_end = '2099-01-01 23:59:59';
            $scheduler->job_interval = "0::3::*::*::*";
            $scheduler->created_by = '1';
            $scheduler->modified_user_id = '1';
            $scheduler->status = 'Inactive';
            $scheduler->catch_up = '1';
            $scheduler->save();
        }
    }

    /**
     * This function will delete created Marketo Schedulers to SugarCRM. It should be called on deleting Marketo.
     * @throws SugarQueryException
     */
    protected static function deleteSchedulers()
    {
        $jobs = array('function::marketoSync', 'function::marketoActivityLogSync', 'function::marketoPurgeOldJobs');
        /** @var Scheduler $schedulerList */
        $schedulerList = BeanFactory::getBean('Schedulers');
        $sugarQuery = new SugarQuery();
        $sugarQuery->from($schedulerList)
            ->where()->in('job', $jobs);

        /** @var Scheduler $scheduler */
        foreach ($schedulerList->fetchFromQuery($sugarQuery, array('id')) as $scheduler) {
            $scheduler->mark_deleted($scheduler->id);
        }
    }

    /**
     * This function will inactivate created Marketo Schedulers to SugarCRM. It should be called on disabling Marketo.
     * @throws SugarQueryException
     */
    public static function inactivateSchedulers()
    {
        $jobs = array('function::marketoSync', 'function::marketoActivityLogSync', 'function::marketoPurgeOldJobs');
        /** @var Scheduler $schedulerList */
        $schedulerList = BeanFactory::getBean('Schedulers');
        $sugarQuery = new SugarQuery();
        $sugarQuery->from($schedulerList);
        $sugarQuery->where()->in('job', $jobs);
        $sugarQuery->where()->equals('status', 'Active');

        /** @var Scheduler $scheduler */
        foreach ($schedulerList->fetchFromQuery($sugarQuery) as $scheduler) {
            $scheduler->status = 'Inactive';
            $scheduler->save();
        }
    }

    /**
     * This function will activate created Marketo Schedulers to SugarCRM. It should be called on enabling Marketo.
     * @throws SugarQueryException
     */
    public static function activateSchedulers()
    {
        $jobs = array('function::marketoSync', 'function::marketoActivityLogSync', 'function::marketoPurgeOldJobs');
        /** @var Scheduler $schedulerList */
        $schedulerList = BeanFactory::getBean('Schedulers');
        $sugarQuery = new SugarQuery();
        $sugarQuery->from($schedulerList);
        $sugarQuery->where()->in('job', $jobs);
        $sugarQuery->where()->equals('status', 'Inactive');

        /** @var Scheduler $scheduler */
        foreach ($schedulerList->fetchFromQuery($sugarQuery) as $scheduler) {
            $scheduler->status = 'Active';
            $scheduler->save();
        }
    }

    function getFieldValue($bean, $field, $value)
    {
        if (!is_object($bean)) {
            $bean = new Lead();
        }

        $mapping = MarketoFactory::getInstance(false)->getMapping();

        if (isset($mapping['beans'][$bean->object_name . 's'][strtolower($field)])) {
            $field = $mapping['beans'][$bean->object_name . 's'][strtolower($field)];
        } else {
            return $value;
        }

        if (isset($bean->field_defs[$field]['type'])) {

            if ($bean->field_defs[$field]['type'] == 'multienum') {
                /* remove spaces */
                $value = str_ireplace(' , ', ',', $value);
                $value = str_ireplace('^', '', $value);
                /* change commas to semi-colons */
                $value = str_ireplace(',', ';', $value);
                /* turn into an array */
                $value = explode(';', $value);
            } else {
                if ($bean->field_defs[$field]['type'] == 'datetimecombo') {
                    $date = new DateTime($value);
                    $date->setTimeZone(new DateTimeZone('GMT'));
                    $value = $date->format(TimeDate::DB_DATETIME_FORMAT);
                }
            }

            $detail = array($field => $value);

            $sugarField = SugarFieldHandler::getSugarField($bean->field_defs[$field]['type']);
            $sugarField->save($bean, $detail, $field, $bean->field_defs[$field]);

        } else {
            $bean->$field = $value;
        }
        return $bean->$field;

    }

    /**
     * Get primary email (previously email1) of a bean.
     *
     * @param SugarBean $bean
     * @return null|string
     */
    public static function getBeanPrimaryEmail($bean)
    {
        // We no longer use legacy email fields, but we need emailAddress->addresses to be populated.
        if (empty($bean->emailAddress->addresses)) {
            $bean->emailAddress->handleLegacyRetrieve($bean);
        }

        $email = null;
        $email = $bean->emailAddress->getPrimaryAddress($bean);
        if (empty($email)) {
            foreach ($bean->emailAddress->addresses as $email) {
                if ((bool)$email['primary_address'] === true) {
                    $email = $email['email_address'];
                    break;
                }
            }
        }
        return $email;
    }

    function isInvalidEmail($email, $bean)
    {
        $invalid = false;
        $email = trim($email);
        if (empty($email)) {
            return false;
        }

        $quotedEmail = $GLOBALS['db']->quote($email);
        $quotedEmailCaps = $GLOBALS['db']->quote(strtoupper($email));
        $q = "SELECT ea.invalid_email FROM email_addr_bean_rel eabl JOIN email_addresses ea ON (ea.id = eabl.email_address_id)
           JOIN {$bean->table_name} bean ON (eabl.bean_id = bean.id)
           WHERE (ea.email_address_caps = '{$quotedEmailCaps}' OR ea.email_address = '{$quotedEmail}')
           AND eabl.bean_module = '{$bean->module_dir}' AND bean.id = '{$bean->id}' AND eabl.deleted=0 ";

        $r = $GLOBALS['db']->query($q);
        while ($row = $GLOBALS['db']->fetchByAssoc($r)) {
            return $row['invalid_email'];
        }

        return $invalid;
    }

    function isUniqueEmail($email, $bean, $clean = false)
    {
        $unique = true;
        $email = trim($email);
        if (empty($email)) {
            return false;
        }

        $quotedEmail = $GLOBALS['db']->quote($email);
        $quotedEmailCaps = $GLOBALS['db']->quote(strtoupper($email));
        $q = "SELECT eabl.id FROM email_addr_bean_rel eabl JOIN email_addresses ea ON (ea.id = eabl.email_address_id)
           JOIN {$bean->table_name} bean ON (eabl.bean_id = bean.id)
           WHERE (ea.email_address_caps = '{$quotedEmailCaps}' OR ea.email_address = '{$quotedEmail}')
           AND eabl.bean_module = '{$bean->module_dir}' AND bean.id = '{$bean->id}' AND eabl.deleted=0 ";

        $r = $GLOBALS['db']->query($q);
        $i = 0;
        while ($row = $GLOBALS['db']->fetchByAssoc($r)) {
            $unique = false;
            ++$i;

            if ($i > 1 && $clean) {
                $query = "update email_addr_bean_rel set deleted = 1 where id = '" . $row['id'] . "'";
                $GLOBALS['db']->query($query);
            }
        }

        return $unique;
    }

    function cleanContacts()
    {

        $contact = new Contact();
        $contact->disable_row_level_security = true;

        $query = "
	   	SELECT count(*) as c, eabl.bean_id, ea.email_address
	   	FROM email_addr_bean_rel eabl JOIN email_addresses ea ON (ea.id = eabl.email_address_id) JOIN contacts bean ON (eabl.bean_id = bean.id)
	   	WHERE eabl.bean_module = 'Contacts' and eabl.deleted = 0
	   	group by eabl.bean_id, ea.email_address
	   	having c > 1";

        $results = $GLOBALS['db']->query($query);
        while ($row = $GLOBALS['db']->fetchByAssoc($results)) {

            echo "<pre>" . print_r($row, true) . "</pre>";
            $contact->retrieve($row['bean_id']);

            MarketoHelper::cleanEmail($row['email_address'], $contact);
        }
    }

    function cleanLeads()
    {

        $lead = new Lead();
        $lead->disable_row_level_security = true;

        $query = "
                SELECT count(*) as c, eabl.bean_id, ea.email_address
                FROM email_addr_bean_rel eabl JOIN email_addresses ea ON (ea.id = eabl.email_address_id) JOIN leads bean ON (eabl.bean_id = bean.id)
                WHERE eabl.bean_module = 'Leads' and eabl.deleted = 0
                group by eabl.bean_id, ea.email_address
                having c > 1";

        $results = $GLOBALS['db']->query($query);
        while ($row = $GLOBALS['db']->fetchByAssoc($results)) {

            echo "<pre>" . print_r($row, true) . "</pre>";
            $lead->retrieve($row['bean_id']);

            MarketoHelper::cleanEmail($row['email_address'], $lead);
        }
    }

    public static function getCustomOpportunitiesFields()
    {
        return array(
            'mrkto2_fiscal_year_c' =>
                array(
                    'id' => 'Opportunitiesmrkto2_fiscal_year_c',
                    'name' => 'mrkto2_fiscal_year_c',
                    'label' => 'LBL_MRKTO2_FISCAL_YEAR',
                    'comments' => '',
                    'help' => '',
                    'module' => 'Opportunities',
                    'type' => 'int',
                    'max_size' => '4',
                    'require_option' => '0',
                    'default_value' => '',
                    'date_modified' => '2012-08-13 18:49:28',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => '2012',
                    'ext2' => '2100',
                    'ext3' => '1',
                    'ext4' => '',
                ),
            'mrkto2_fiscal_quarter_c' =>
                array(
                    'id' => 'Opportunitiesmrkto2_fiscal_quarter_c',
                    'name' => 'mrkto2_fiscal_quarter_c',
                    'label' => 'LBL_MRKTO2_FISCAL_QUARTER',
                    'comments' => '',
                    'help' => '',
                    'module' => 'Opportunities',
                    'type' => 'enum',
                    'max_size' => '100',
                    'require_option' => '0',
                    'default_value' => '1',
                    'date_modified' => '2012-08-13 18:58:22',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'true',
                    'options' => 'mkto_fiscal_quarter_list',
                ),
            'mrkto2_is_won_c' =>
                array(
                    'id' => 'Opportunitiesmrkto2_is_won_c',
                    'name' => 'mrkto2_is_won_c',
                    'label' => 'LBL_MRKTO2_IS_WON',
                    'comments' => '',
                    'help' => '',
                    'module' => 'Opportunities',
                    'type' => 'bool',
                    'max_size' => '255',
                    'require_option' => '0',
                    'default_value' => '0',
                    'date_modified' => '2012-08-13 19:07:25',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'true',
                    'enforced' => 'false',
                    'readonly' => '1',
                    'ext1' => '',
                    'ext2' => '',
                    'ext3' => '',
                    'ext4' => '',
                ),
            'mrkto2_is_closed_c' =>
                array(
                    'id' => 'Opportunitiesmrkto2_is_closed_c',
                    'name' => 'mrkto2_is_closed_c',
                    'label' => 'LBL_MRKTO2_IS_CLOSED',
                    'comments' => '',
                    'help' => '',
                    'module' => 'Opportunities',
                    'type' => 'bool',
                    'max_size' => '255',
                    'require_option' => '0',
                    'default_value' => '0',
                    'date_modified' => '2012-08-13 19:07:47',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'true',
                    'enforced' => 'true',
                    'readonly' => '1',
                    'ext1' => '',
                    'ext2' => '',
                    'ext3' => '',
                    'ext4' => '',
                ),
            'mrkto2_forecastcategoryname_c' =>
                array(
                    'id' => 'Opportunitiesmrkto2_forecastcategoryname_c',
                    'name' => 'mrkto2_forecastcategoryname_c',
                    'label' => 'LBL_MRKTO2_FORECASTCATEGORYNAME',
                    'comments' => '',
                    'help' => '',
                    'module' => 'Opportunities',
                    'type' => 'enum',
                    'max_size' => '100',
                    'require_option' => '0',
                    'default_value' => '',
                    'date_modified' => '2012-08-13 19:15:14',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'true',
                    'options' => 'mkto_forecastcategoryname_list',
                ),
            'mrkto2_expected_revenue_c' =>
                array(
                    'id' => 'Opportunitiesmrkto2_expected_revenue_c',
                    'name' => 'mrkto2_expected_revenue_c',
                    'label' => 'LBL_MRKTO2_EXPECTED_REVENUE',
                    'comments' => '',
                    'help' => '',
                    'module' => 'Opportunities',
                    'type' => 'currency',
                    'max_size' => '26',
                    'require_option' => '0',
                    'default_value' => '',
                    'date_modified' => '2012-08-13 19:16:55',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => '',
                    'ext2' => '',
                    'ext3' => '',
                    'ext4' => '',
                ),
        );
    }

    public static function getCustomContactsFields()
    {
        return array(
            'mrkto2_anonymousip_c' =>
                array(
                    'id' => 'Contactsmrkto2_anonymousip_c',
                    'name' => 'mrkto2_anonymousip_c',
                    'label' => 'LBL_MRKTO2_ANONYMOUSIP',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'varchar',
                    'max_size' => '30',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:52:59',
                    'deleted' => '0',
                    'audited' => '0',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_do_not_call_reason_c' =>
                array(
                    'id' => 'Contactsmrkto2_do_not_call_reason_c',
                    'name' => 'mrkto2_do_not_call_reason_c',
                    'label' => 'LBL_MRKTO2_DO_NOT_CALL_REASON',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'varchar',
                    'max_size' => '100',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:53:01',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_inferred_company_c' =>
                array(
                    'id' => 'Contactsmrkto2_inferred_company_c',
                    'name' => 'mrkto2_inferred_company_c',
                    'label' => 'LBL_MRKTO2_INFERRED_COMPANY_C',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'varchar',
                    'max_size' => '50',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:52:51',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_inferred_country_c' =>
                array(
                    'id' => 'Contactsmrkto2_inferred_country_c',
                    'name' => 'mrkto2_inferred_country_c',
                    'label' => 'LBL_MRKTO2_INFERRED_COUNTRY_C',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'varchar',
                    'max_size' => '30',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:52:53',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_middle_name_c' =>
                array(
                    'id' => 'Contactsmrkto2_middle_name_c',
                    'name' => 'mrkto2_middle_name_c',
                    'label' => 'LBL_MRKTO2_MIDDLE_NAME',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'varchar',
                    'max_size' => '100',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:53:04',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_rating_c' =>
                array(
                    'id' => 'Contactsmrkto2_rating_c',
                    'name' => 'mrkto2_rating_c',
                    'label' => 'LBL_MRKTO2_RATING',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'varchar',
                    'max_size' => '50',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:53:07',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_role_c' =>
                array(
                    'id' => 'Contactsmrkto2_role_c',
                    'name' => 'mrkto2_role_c',
                    'label' => 'LBL_MRKTO2_ROLE',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'varchar',
                    'max_size' => '255',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:53:08',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_site_c' =>
                array(
                    'id' => 'Contactsmrkto2_site_c',
                    'name' => 'mrkto2_site_c',
                    'label' => 'LBL_MRKTO2_SITE',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'varchar',
                    'max_size' => '100',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:53:11',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_unsubscribed_c' =>
                array(
                    'id' => 'Contactsmrkto2_unsubscribed_c',
                    'name' => 'mrkto2_unsubscribed_c',
                    'label' => 'LBL_MRKTO2_UNSUBSCRIBED',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'bool',
                    'max_size' => '255',
                    'require_option' => '0',
                    'default_value' => '0',
                    'date_modified' => '2010-05-04 14:53:12',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_unsubscribed_reason_c' =>
                array(
                    'id' => 'Contactsmrkto2_unsubscribed_reason_c',
                    'name' => 'mrkto2_unsubscribed_reason_c',
                    'label' => 'LBL_MRKTO2_UNSUBSCRIBED_REASON',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'text',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:53:13',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
             'mrkto2_unsubscribed_date_c' =>
                array(
                    'id' => 'Contactsmrkto2_unsubscribed_date_c',
                    'name' => 'mrkto2_unsubscribed_date_c',
                    'label' => 'LBL_MRKTO2_UNSUBSCRIBED_DATE',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'date',
                    'max_size' => '10',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2015-12-01 12:00:00',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
             'mrkto2_invalid_email_date_c' =>
                array(
                    'id' => 'Contactsmrkto2_invalid_email_date_c',
                    'name' => 'mrkto2_invalid_email_date_c',
                    'label' => 'LBL_MRKTO2_INVALID_EMAIL_DATE',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Contacts',
                    'type' => 'date',
                    'max_size' => '10',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2015-12-01 12:00:00',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
        );
    }

    public static function getCustomLeadFields()
    {
        return array(
            'mrkto2_industry_c' =>
                array(
                    'id' => 'Leadsmrkto2_industry_c',
                    'name' => 'mrkto2_industry_c',
                    'label' => 'LBL_MRKTO2_INDUSTRY',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Leads',
                    'type' => 'enum',
                    'max_size' => '255',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:53:03',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => 'industry_dom',
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_main_phone_c' =>
                array(
                    'id' => 'Leadsmrkto2_main_phone_c',
                    'name' => 'mrkto2_main_phone_c',
                    'label' => 'LBL_MRKTO2_MAIN_PHONE',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Leads',
                    'type' => 'phone',
                    'max_size' => '30',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:52:57',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_number_of_employees_c' =>
                array(
                    'id' => 'Leadsmrkto2_number_of_employees_c',
                    'name' => 'mrkto2_number_of_employees_c',
                    'label' => 'LBL_MRKTO2_NUMBER_OF_EMPLOYEES',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Leads',
                    'type' => 'int',
                    'max_size' => '11',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:53:05',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_sic_code_c' =>
                array(
                    'id' => 'Leadsmrkto2_sic_code_c',
                    'name' => 'mrkto2_sic_code_c',
                    'label' => 'LBL_MRKTO2_SIC_CODE',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Leads',
                    'type' => 'varchar',
                    'max_size' => '10',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:53:09',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
            'mrkto2_annualrevenue_c' =>
                array(
                    'id' => 'Leadsmrkto2_annualrevenue_c',
                    'name' => 'mrkto2_annualrevenue_c',
                    'label' => 'LBL_MRKTO2_ANNUALREVENUE_C',
                    'comments' => null,
                    'help' => null,
                    'module' => 'Leads',
                    'type' => 'currency',
                    'max_size' => '26',
                    'require_option' => '0',
                    'default_value' => null,
                    'date_modified' => '2010-05-04 14:52:58',
                    'deleted' => '0',
                    'audited' => '1',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => null,
                    'ext2' => null,
                    'ext3' => null,
                    'ext4' => null,
                ),
        );
    }

    public static function getCustomFields($type)
    {
        switch ($type) {
            case 'Opportunities':
                return self::getCustomOpportunitiesFields();
            case 'Contacts':
                return self::getCustomContactsFields();
            case 'Leads':
                $fields = self::getCustomContactsFields();
                foreach ($fields as $field => $fieldDefinition) {
                    $fields[$field]['module'] = 'Leads';
                    $fields[$field]['id'] = $fields[$field]['module'] . $fieldDefinition['name'];

                }
                return array_merge($fields, self::getCustomLeadFields());
        }
    }

    public static function addFieldToScreens()
    {
        $person_fields = array(
            array(
                array(
                    'name' => 'mkto_sync',
                    'comment' => 'Should the Lead be synced to Marketo',
                    'label' => 'LBL_MKTO_SYNC',
                ),
                array(
                    'name' => 'mkto_lead_score',
                    'comment' => null,
                    'label' => 'LBL_MKTO_LEAD_SCORE',
                ),
            ),
            array(
                array(
                    'name' => 'mkto_id',
                    'comment' => 'Associated Marketo Lead ID',
                    'readonly' => '1',
                    'label' => 'LBL_MKTO_ID',
                    'span' => 6,
                ),
                MBConstants::$FILLER
            )
        );

        self::addFields('Leads', $person_fields);
        self::addFields('Contacts', $person_fields);


        $opportunity_fields = array(
            array(
                array(
                    'name' => 'mkto_sync',
                    'comment' => 'Should the Lead be synced to Marketo',
                    'label' => 'LBL_MKTO_SYNC',
                ),
                array(
                    'name' => 'mkto_id',
                    'comment' => 'Associated Marketo Lead ID',
                    'readonly' => '1',
                    'label' => 'LBL_MKTO_ID',
                ),
            ),
            array(
                array(
                    'name' => 'mrkto2_is_closed_c',
                    'label' => 'LBL_MRKTO2_IS_CLOSED',
                    'readonly' => '1',
                ),
                array(
                    'name' => 'mrkto2_is_won_c',
                    'label' => 'LBL_MRKTO2_IS_WON',
                    'readonly' => '1',
                ),
            ),
            array(
                array(
                    'name' => 'mrkto2_fiscal_quarter_c',
                    'studio' => 'visible',
                    'label' => 'LBL_MRKTO2_FISCAL_QUARTER',
                ),
                array(
                    'name' => 'mrkto2_fiscal_year_c',
                    'label' => 'LBL_MRKTO2_FISCAL_YEAR',
                )
            ),
            array(
                array(
                    'related_fields' =>
                        array(
                            0 => 'currency_id',
                            1 => 'base_rate',
                        ),
                    'name' => 'mrkto2_expected_revenue_c',
                    'label' => 'LBL_MRKTO2_EXPECTED_REVENUE',
                    'span' => 6,
                ),
                MBConstants::$FILLER
            )
        );

        self::addFields('Opportunities', $opportunity_fields);

    }

    public static function addFields($module, $mkto_fields)
    {
        $update = true;
        $parser = ParserFactory::getParser(MB_RECORDVIEW, $module);
        $layouts = $parser->getLayout();
        foreach ($layouts as $panel => $rows) {
            foreach ($rows as $row => $columns) {
                foreach ($columns as $id => $fields) {
                    if ($fields['name'] === 'mkto_sync') {
                        $update = false;
                        break 3;
                    }
                }
            }
        }

        if ($update) {
            foreach ($mkto_fields as $row => $columns) {
                $parser->_viewdefs['panels']['LBL_RECORD_BODY'][] = $columns;
            }
            $parser->handleSave(false);
        }
    }

    public static function addFieldToSugar6Screens()
    {
        $opportunity_fields = array(
            'mkto_sync' => array('name' => 'mkto_sync', 'row' => 0, 'column' => 0),
            'mkto_id' => array('name' => 'mkto_id', 'row' => 0, 'column' => 1),
            'mrkto2_fiscal_year_c' => array('name' => 'mrkto2_fiscal_year_c', 'row' => 1, 'column' => 0),
            'mrkto2_fiscal_quarter_c' => array('name' => 'mrkto2_fiscal_quarter_c', 'row' => 1, 'column' => 1),
            'mrkto2_forecastcategoryname_c' => array(
                'name' => 'mrkto2_forecastcategoryname_c',
                'row' => 2,
                'column' => 0
            ),
            'mrkto2_expected_revenue_c' => array('name' => 'mrkto2_expected_revenue_c', 'row' => 2, 'column' => 1),
            'mrkto2_is_won_c' => array('name' => 'mrkto2_is_won_c', 'row' => 3, 'column' => 0),
            'mrkto2_is_closed_c' => array('name' => 'mrkto2_is_closed_c', 'row' => 3, 'column' => 1),
        );

        $fields = array(
            'mkto_sync' => array('name' => 'mkto_sync', 'row' => 0, 'column' => 0),
            'mkto_lead_score' => array('name' => 'mkto_lead_score', 'row' => 1, 'column' => 0),
            'mkto_id' => array('name' => 'mkto_id', 'row' => 1, 'column' => 1),
            'mrkto2_middle_name_c' => array('name' => 'mrkto2_middle_name_c', 'row' => 2, 'column' => 0),
            'mrkto2_main_phone_c' => array('name' => 'mrkto2_main_phone_c', 'row' => 2, 'column' => 1),
            'mrkto2_anonymousip_c' => array('name' => 'mrkto2_anonymousip_c', 'row' => 3, 'column' => 1),
            'mrkto2_role_c' => array('name' => 'mrkto2_role_c', 'row' => 4, 'column' => 0),
            'mrkto2_annualrevenue_c' => array('name' => 'mrkto2_annualrevenue_c', 'row' => 4, 'column' => 1),
            'mrkto2_industry_c' => array('name' => 'mrkto2_industry_c', 'row' => 5, 'column' => 0),
            'mrkto2_rating_c' => array('name' => 'mrkto2_rating_c', 'row' => 6, 'column' => 0),
            'mrkto2_number_of_employees_c' => array(
                'name' => 'mrkto2_number_of_employees_c',
                'row' => 6,
                'column' => 1
            ),
            'mrkto2_site_c' => array('name' => 'mrkto2_site_c', 'row' => 7, 'column' => 0),
            'mrkto2_sic_code_c' => array('name' => 'mrkto2_sic_code_c', 'row' => 7, 'column' => 1),
            'mrkto2_inferred_company_c' => array('name' => 'mrkto2_inferred_company_c', 'row' => 8, 'column' => 0),
            'mrkto2_inferred_country_c' => array('name' => 'mrkto2_inferred_country_c', 'row' => 8, 'column' => 1),
            'mrkto2_unsubscribed_c' => array('name' => 'mrkto2_unsubscribed_c', 'row' => 9, 'column' => 0),
            'mrkto2_unsubscribed_reason_c' => array(
                'name' => 'mrkto2_unsubscribed_reason_c',
                'row' => 9,
                'column' => 1
            ),
        );


        self::addSugar6Fields('Leads', $fields);
        self::addSugar6Fields('Contacts', $fields);
        self::addSugar6Fields('Opportunities', $opportunity_fields);
    }

    public static function addSugar6Fields($module, $fields)
    {
        $views = array(
            MB_DETAILVIEW,
            MB_EDITVIEW
        );

        foreach ($views as $view) {
            $parser = ParserFactory::getParser($view, $module);

            foreach ($fields as $field => $def) {

                $properties = array(
                    'name' => $field,
                );
                self::addSugar6Field($parser, $properties, $def['row'], $def['column']);
            }

            if ($module != 'Opportunities') {
                /* Added a couple of Filler Fields */
                self::addSugar6Field($parser, MBConstants::$FILLER, 0, 1);
                self::addSugar6Field($parser, MBConstants::$FILLER, 5, 1);
            }

            $parser->handleSave(false); //Do not populate from $_REQUEST
        }
    }

    public static function addSugar6Field(&$parser, $def, $row, $column)
    {
        if (!isset($parser->_viewdefs['panels']['LBL_MARKETO'])) {
            $parser->_viewdefs['panels']['LBL_MARKETO'][] = '';
        }

        if (isset ($parser->_viewdefs ['panels'] ['LBL_MARKETO'])) {
            $parser->_viewdefs['panels']['LBL_MARKETO'][$row][$column] = $def['name'];

            // now update the fielddefs
            if (isset($parser->_fielddefs [$def ['name']])) {
                $parser->_fielddefs [$def ['name']] = array_merge($parser->_fielddefs [$def ['name']], $def);
            } else {
                $parser->_fielddefs [$def ['name']] = $def;
            }
        }
        return true;
    }

    public static function addCustomFieldProperties(array $fieldDefinition, array $properties)
    {
        $module = $fieldDefinition['module'];

        unset($fieldDefinition['id']);
        $fieldDefinition['view_module'] = $module;
        $fieldDefinition['module'] = 'ModuleBuilder';

        $df = new DynamicField($module);
        $bean = BeanFactory::getBean($module);
        $df->setup($bean);

        $field = get_widget('bool');
        $_REQUEST = $fieldDefinition;
        $field->populateFromPost();

        foreach($properties as $propertyName => $propertyValue) {
            $field->$propertyName = $propertyValue;
            if (!isset($field->vardef_map[$propertyName])) {
                $field->vardef_map[$propertyName] = $propertyName;
            }
        }

        $df->addFieldObject($field);
        
        include_once 'modules/Administration/QuickRepairAndRebuild.php';
        global $mod_strings;
        $mod_strings['LBL_ALL_MODULES'] = 'all_modules';
        $repair = new RepairAndClear();

        // Set up an array for repairing modules
        $repairModules = array($module);
        $repair->repairAndClearAll(array('rebuildExtensions', 'clearVardefs', 'clearTpls', 'clearSearchCache'), $repairModules, true, false);
    }

    /**
     * Creates mapping that will be updated on install.
     * $fieldsToChange - array with modules and fields to upgrade.
     * Field will be updated if current field value in mapping is equals to 'old' value in $fieldsToChange
     *
     * @return array
     */
    public static function getMappingForUpdateOnInstall()
    {
        $fieldsToChange = array(
            'Leads' => array(
                'email' => array(
                    'old' => 'email1',
                    'new' => 'email',
                ),
            ),
            'Contacts' => array(
                'email' => array(
                    'old' => 'email1',
                    'new' => 'email',
                ),
            ),
        );

        $marketo = MarketoFactory::getInstance();
        $currentMapping = $marketo->getMapping();
        if (!isset($currentMapping['beans'])) {
            return array();
        }
        $isChanged = false;
        foreach ($currentMapping['beans'] as $moduleName => &$module) {
            if (!isset($fieldsToChange[$moduleName])) {
                continue;
            }
            foreach ($fieldsToChange[$moduleName] as $keyToChange => $valuesToChange) {
                if (isset($module[$keyToChange]) && $module[$keyToChange] == $valuesToChange['old']) {
                    $module[$keyToChange] = $valuesToChange['new'];
                    $isChanged = true;
                }
            }
        }

        return $isChanged ? $currentMapping : array();
    }
}
