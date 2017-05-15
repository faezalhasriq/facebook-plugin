<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

require_once 'include/api/SugarListApi.php';
require_once 'custom/include/DRI/FacebookConfig.php';
require_once 'custom/include/DRI/FacebookLicenseValidator.php';
require_once 'custom/include/DRI/FacebookSugarOutfittersClient.php';

class FacebookDashletApi extends SugarApi
{

    /**
     * @return array
     */
    public function registerApiRest()
    {
        return array(
            'checkLicense' => array(
                'reqType' => 'GET',
                'path' => array('license_validator', 'facebook'),
                'pathVars' => array(),
                'method' => 'checkLicense',
                'shortHelp' => 'Validates the Facebook license',
                'longHelp' => '',
            ),
        );
    }

    /**
     * Check for valid license-key
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function checkLicense($api, $args)
    {
        $return = array(
            'valid' => true,
        );

        try {
            $config = new FacebookConfig();
            if ($config->getLicenseType() == FacebookConfig::LICENCE_TYPE_OUTFITTERS) {
                $data = array(
                    FacebookSugarOutfittersClient::PARAM_LICENSE_KEY => $config->getLicenseKey(),
                    #FacebookSugarOutfittersClient::PARAM_PUBLIC_KEY => '20e0739c35005146b02cd75e3e798304,3f3f66f6203487c711029e753c6c74d6',
                );
                $client = new FacebookSugarOutfittersClient();
                $client->validate('facebook_dashlet', $data);
            } else {
                $validator = new FacebookLicenseValidator();
                $validator->validateKey(
                    'facebook_dashlet', $config->getLicenseKey(), $config->getValidationKey()
                );
            }
        } catch (\SugarApiException $e) {
            if ('ERROR_INVALID_LICENSE' !== $e->messageLabel) {
                throw $e;
            } else {
                $return['valid'] = false;
            }
        }

        return $return;
    }
}