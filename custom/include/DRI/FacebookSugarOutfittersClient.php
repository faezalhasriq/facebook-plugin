<?php

require_once 'modules/Administration/Administration.php';
require_once 'custom/include/DRI/Exception/InvalidLicenseException.php';

/**
 * @author Emil Kilhage
 */
class FacebookSugarOutfittersClient
{
    const PARAM_LICENSE_KEY = 'key';
    const PARAM_PUBLIC_KEY  = 'public_key';

    const CACHE_LAST_RAN    = 'last_ran';
    const CACHE_LAST_RESULT = 'last_result';
    const CACHE_PARAMS      = 'params';

    /**
     * @var string
     */
    private $url = 'https://www.sugaroutfitters.com/api/v1';

    /**
     * @var string
     */
    private $validationFrequency = '+ 1 week';

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $validationFrequency
     */
    public function setValidationFrequency($validationFrequency)
    {
        $this->validationFrequency = $validationFrequency;
    }

    /**
     * @param string $name
     * @param array  $data
     * @return array
     * @throws \SugarApiExceptionRequestMethodFailure
     */
    public function validate($name, array $data)
    {
        $result = $this->getLastValidation($name, $data);

        // force revalidation if the cached result is invalid
        if (null !== $result && !$this->isValid($data, $result)) {
            $result = null;
        }

        if (null === $result) {
            $result = $this->doValidate($name, $data);
        }

        if (!$this->isValid($data, $result)) {
            throw new InvalidLicenseException('LBL_FACEBOOK_DASHLET_INVALID_LICENSE_ERROR_MESSAGE');
        }

        return $result;
    }

    /**
     * @param string $name
     * @return array|null
     */
    private function getLastValidation($name, array $data)
    {
        // retrieve checked check
        $administration = $this->getAdmin();

        $key = 'SugarOutfitters_' . $name;
        if (!isset($administration->settings[$key])) {
            return null;
        }

        $lastValidation = $administration->settings[$key];

        $lastValidation = json_decode($lastValidation, true);

        $params = $lastValidation[self::CACHE_PARAMS];

        // have the license key changed?
        if ($params[self::PARAM_LICENSE_KEY] !== $data[self::PARAM_LICENSE_KEY]) {
            return null;
        }

        // have the public key changed?
        if ($params[self::PARAM_PUBLIC_KEY] !== $data[self::PARAM_PUBLIC_KEY]) {
            return null;
        }

        $lastRun = new \DateTime($lastValidation[self::CACHE_LAST_RAN]);
        $lastRun->modify($this->validationFrequency);

        $now = new \DateTime();

        // is the cached check still valid?
        if ($lastRun < $now) {
            return null;
        }

        return $lastValidation[self::CACHE_LAST_RESULT];
    }

    /**
     * @param string $name
     * @param array  $data
     * @return array
     * @throws \InvalidLicenseException
     */
    private function doValidate($name, array $data)
    {
        // build request
        $url = "{$this->url}/key/validate?" . http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        // execute request
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        // check for errors
        if ($info['http_code'] === 0) {
            $GLOBALS['log']->fatal(__METHOD__ . ': Unable to validate license.');
            throw new InvalidLicenseException('ERROR_INVALID_LICENSE_KEY');
        } else if ($info['http_code'] !== 200) {
            $GLOBALS['log']->fatal(__METHOD__ . ': HTTP Request failed.' . print_r($info, true));
            throw new InvalidLicenseException('LBL_FACEBOOK_DASHLET_INVALID_LICENSE_ERROR_MESSAGE');
        }

        // parse response
        $result = json_decode($response, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            $GLOBALS['log']->fatal(__METHOD__.': HTTP Request failed. json error: '.json_last_error_msg());
            throw new InvalidLicenseException('LBL_FACEBOOK_DASHLET_INVALID_LICENSE_ERROR_MESSAGE');
        }

        // only save valid checks
        if ($this->isValid($data, $result)) {
            $now = new \DateTime();
            $store = array(
                self::CACHE_LAST_RAN => $now->format(\DateTime::ISO8601),
                self::CACHE_LAST_RESULT => $result,
                self::CACHE_PARAMS => $data,
            );

            $serialized = json_encode($store);
            $administration = $this->getAdmin();
            $administration->saveSetting('SugarOutfitters', $name, $serialized);
        }

        return $result;
    }

    /**
     * @return \Administration
     */
    private function getAdmin()
    {
        $administration = new \Administration();
        $administration->retrieveSettings();
        return $administration;
    }

    /**
     * @param array $data
     * @param $result
     * @return array
     */
    private function isValid(array $data, $result)
    {
        if (!$result['validated']) {
            return false;
        }

        return true;
    }
}
