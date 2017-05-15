<?php

/**
 * @author Emil Kilhage
 */
class FacebookConfig
{
    const LICENCE_TYPE_ADDOPTIFY = 'addoptify';
    const LICENCE_TYPE_OUTFITTERS = 'outfitters';

    /**
     * @var array
     */
    private static $availableKeys = array(
        'fb_license_type',
        'fb_license_key',
        'fb_validation_key'
    );

    /**
     * @var array|null
     */
    private $properties;

    /**
     * @return array
     */
    public function load()
    {
        if (is_null($this->properties)) {
            $admin = \Administration::getSettings('Cases');

            foreach (self::$availableKeys as $availableKey) {
                $key = 'Cases_'.$availableKey;

                if (isset($admin->settings[$key])) {
                    $this->properties[$availableKey] = $admin->settings[$key];
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getLicenseType()
    {
        return $this->getValue('fb_license_type');
    }

    /**
     * @return string
     */
    public function getLicenseKey()
    {
        return $this->getValue('fb_license_key');
    }

    /**
     * @return string
     */
    public function getValidationKey()
    {
        return $this->getValue('fb_validation_key');
    }

    /**
     * @param string $name
     * @param null $default
     *
     * @return null
     */
    private function getValue($name, $default = null)
    {
        $this->load();
        return isset($this->properties[$name]) ? $this->properties[$name] : $default;
    }
}