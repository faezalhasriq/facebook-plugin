<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once('include/api/SugarApi.php');
require_once('include/externalAPI/Marketo/MarketoFactory.php');
require_once('include/connectors/sources/SourceFactory.php');

class MarketoApi extends SugarApi
{
    /**
     * Setup the endpoint that belong to this API EndPoint
     *
     * @return array
     */
    public function registerApiRest()
    {
        return array(
            'getLead' => array(
                'reqType' => 'GET',
                'path' => array('connector', 'marketo', '?', '?'),
                'pathVars' => array('connector', 'module', 'keyType', 'keyValue'),
                'method' => 'getLead',
                'shortHelp' => 'Retrieves a single lead record from Marketo',
                'longHelp' => 'include/api/help/connector_marketo_get_lead_help.html',
            ),
            'getSchema' => array(
                'reqType' => 'GET',
                'path' => array('connector', 'marketo', 'schema'),
                'pathVars' => array(),
                'method' => 'getSchema',
                'shortHelp' => 'Returns the metadata for Standard and Virtual MObjects',
                'longHelp' => 'include/api/help/connector_marketo_get_schema_help.html',
            ),
            'config' => array(
                'reqType' => 'GET',
                'path' => array('connector', 'marketo', 'config'),
                'pathVars' => array(),
                'method' => 'getConfiguration',
                'shortHelp' => 'Returns the Marketo connector configuration',
                'longHelp' => 'include/api/help/connector_marketo_get_schema_help.html',
            ),
            'configUpdate' => array(
                'reqType' => 'PUT',
                'path' => array('connector', 'marketo', 'config'),
                'pathVars' => array(),
                'method' => 'setConfiguration',
                'shortHelp' => '',
                'longHelp' => '',
            ),
            'status' => array(
                'reqType' => 'GET',
                'path' => array('connector', 'marketo', 'status'),
                'pathVars' => array(),
                'method' => 'getLeadSynchronizationStatus',
                'shortHelp' => 'Returns information pertaining to the lead synchronization process',
                'longHelp' => 'include/api/help/connector_marketo_get_synchronization_help.html',
            ),
            'activitystatus' => array(
                'reqType' => 'GET',
                'path' => array('connector', 'marketo', 'status', 'activity'),
                'pathVars' => array(),
                'method' => 'getActivityLogSynchronizationStatus',
                'shortHelp' => 'Returns information pertaining to the activity log synchronization process',
                'longHelp' => 'include/api/help/connector_marketo_get_synchronization_help.html',
            ),
            'opportunity' => array(
                'reqType' => 'GET',
                'path' => array('connector', 'marketo', 'opportunity', '?'),
                'pathVars' => array('connector', 'marketo', 'opportunity', 'id'),
                'method' => 'getOpportunity',
                'shortHelp' => 'Returns MObject of type Opportunity with the particular id',
                'longHelp' => 'include/api/help/marketo_get_help.html',
            ),
            'getCampaignsForSource' => array(
                'reqType' => 'GET',
                'path' => array('connector', 'marketo', 'getCampaignsForSource'),
                'method' => 'getCampaignsForSource',
                'shortHelp' => '',
                'longHelp' => '',
            ),
            'reset' => array(
                'reqType' => 'PUT',
                'path' => array('connector', 'marketo', 'reset'),
                'method' => 'resetMarketo',
                'shortHelp' => '',
                'longHelp' => '',
            ),
        );
    }


    /**
     * Utilize the Marketo API for to update the known fields available to be mapped between Marketo and SugarCRM.
     *
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function getSchema($api, $args)
    {
        if (!$api->user->isAdmin()) {
            throw new SugarApiExceptionNotAuthorized();
        }

        $this->requireArgs($args, array('objectName'));
        if (!in_array($args['objectName'], array('LeadRecord', 'Opportunity', 'OpportunityPersonRole'))) {
            throw new SugarApiExceptionInvalidParameter('objectName must be one of LeadRecord, Opportunity or OpportunityPersonRole');
        }

        if (MarketoFactory::getInstance(false)->isEnabled()) {
            return MarketoFactory::getInstance(true)->getSchema($args['objectName']);

        } else {
            throw new SugarApiException(ext_soap_marketo::SERVICE_NOT_ENABLED, null, null, 503);
        }
    }

    /**
     * This function retrieves a single lead record from Marketo, with all field values for the built-in and custom fields, for a lead identified by the provided ID. If the lead exists based on the input parameters, the lead record attributes will be returned.
     *
     * NOTE: Lead attributes that are of string data type and are empty will not be returned as a part of the response.
     *
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiExceptionError
     * @throws SugarApiException
     * @throws SugarApiExceptionInvalidParameter
     */
    public function getLead($api, $args)
    {
        $this->requireArgs($args, array('keyType', 'keyValue'));
        if (!in_array($args['keyType'], array('IDNUM', 'EMAIL'))) {
            throw new SugarApiExceptionInvalidParameter('keyType must be either IDNUM or EMAIL');
        }

        if (MarketoFactory::getInstance(false)->isEnabled()) {

            $data = array();

            $marketo = MarketoFactory::getInstance(true);
            try {
                return $marketo->getLeadViaAPI(new LeadKey($args['keyType'], $args['keyValue']));
            } catch (Exception $e) {
                throw new SugarApiExceptionError($e->getMessage());
            }

            return $data;
        } else {
            throw new SugarApiException(ext_soap_marketo::SERVICE_NOT_ENABLED, null, null, 503);
        }
    }

    /**
     * Provides the status information from the Marketo Leads synchronization process
     *
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function getLeadSynchronizationStatus($api, $args)
    {
        global $timedate;

        if (!$api->user->isAdmin()) {
            throw new SugarApiExceptionNotAuthorized();
        }

        $data = array();
        $administration = BeanFactory::getBean('Administration');
        $settings = $administration->getConfigForModule('marketo', null, true);

        $data['date_modified'] = empty($settings['last successful sync']) ? "" : $timedate->to_display_date_time(
            $settings['last successful sync']
        );
        $data['remainingCount'] = empty($settings['remainingCount']) ? 0 : $settings['remainingCount'];
        return $data;
    }

    /**
     * Provides the status information from the Marketo ActivityLog synchronization process
     *
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function getActivityLogSynchronizationStatus($api, $args)
    {
        global $timedate;

        if (!$api->user->isAdmin()) {
            throw new SugarApiExceptionNotAuthorized();
        }

        $data = array();
        $administration = BeanFactory::getBean('Administration');
        $settings = $administration->getConfigForModule('marketo_activity_log', null, true);

        $data['date_modified'] = empty($settings['last successful sync']) ? "" : $timedate->to_display_date_time(
            $settings['last successful sync']
        );
        $data['remainingCount'] = empty($settings['remainingCount']) ? 0 : $settings['remainingCount'];
        return $data;
    }

    /**
     * Returns the config settings
     *
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionNotAuthorized
     */
    public function getConfiguration($api, $args)
    {
        if (!$api->user->isAdmin()) {
            throw new SugarApiExceptionNotAuthorized();
        }

        return MarketoFactory::getInstance(false)->getConfig();
    }

    /**
     * Save function for the config settings
     *
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionInvalidParameter
     */
    public function setConfiguration($api, $args)
    {
        if (!$api->user->isAdmin()) {
            throw new SugarApiExceptionNotAuthorized();
        }

        $this->requireArgs($args, array('properties'));

        $validProperties = array(
            'enabled',
            'marketo_wsdl',
            'marketo_user_id',
            'marketo_shared_secret',
            'assigned_user_id',
            'download_score',
            'maximum_download',
            'records_to_download',
            'filters'
        );

        //add any properties that were not added by default
        foreach ($validProperties as $valid) {
            foreach ($args['properties'] as $property => $value) {
                $found = false;

                if ($property == $valid) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $args['properties'][$valid] = "";
            }

        }

        foreach ($args['properties'] as $property => $value) {
            switch ($property) {
                case 'enabled':
                    if (!in_array($value, array('1', '2'))) {
                        throw new SugarApiExceptionInvalidParameter('enabled must be either 1 or 2');
                    }
                    break;
                case 'marketo_wsdl':
                case 'marketo_user_id':
                case 'marketo_shared_secret':
                    if (empty($value)) {
                        throw new SugarApiExceptionInvalidParameter("$property is required");
                    }
                    break;
                case 'assigned_user_id':
                    if (empty($value)) {
                        throw new SugarApiExceptionInvalidParameter("$property is required");
                    }
                    $user = BeanFactory::getBean('Users', $value, array('disable_row_level_security' => true));
                    if (empty($user->id)) {
                        throw new SugarApiExceptionInvalidParameter("Invalid $property has been provided");
                    }
                    break;
                case 'download_score':
                    if (empty($value)) {
                        $args['properties']['download_score'] = 0;
                    }
                    break;
                case 'maximum_download':
                    if (empty($value) || ($value != 'unlimited' && !is_int($value))) {
                        $args['properties']['maximum_download'] = 'unlimited';
                    }
                    break;
                case 'records_to_download':
                    if (empty($value) || !is_int($value)) {
                        $args['properties']['records_to_download'] = '100';
                    }
                    break;
                case 'filters':
                    if (empty($value) || !is_array($value)) {
                        $args['properties']['filters'] = array(
                            "ClickEmail",
                            "ClickLink",
                            "EmailDelivered",
                            "FillOutForm",
                            "InterestingMoment",
                            "NewLead",
                            "OpenEmail",
                            "SendEmail"
                        );
                    }
                    foreach ($value as $filter) {
                        if (empty($GLOBALS['app_list_strings']['mkto_activity_type'][$filter])) {
                            throw new SugarApiExceptionInvalidParameter("$filter is not a valid $property");
                        }
                    }
                    break;
                default:
                    throw new SugarApiExceptionInvalidParameter("Invalid $property has been provided");
            }
        }

        $source = SourceFactory::getSource('ext_soap_marketo');
        $source->setProperties($args['properties']);
        $source->saveConfig();

        return MarketoFactory::getInstance(false)->getConfig();
    }

    /**
     * Returns a list of eligible Marketo campaigns
     *
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiException
     * @throws SugarApiExceptionInvalidParameter
     */
    public function getCampaignsForSource($api, $args)
    {
        $this->requireArgs($args, array('source'));


        if (MarketoFactory::getInstance(false)->isEnabled()) {

            if (!in_array(
                $args['source'],
                array(ParamsGetCampaignsForSource::MKTOWS, ParamsGetCampaignsForSource::SALES)
            )
            ) {
                throw new SugarApiExceptionInvalidParameter("Invalid source: {$args['source']}");
            }

            $data = array();

            $successGetCampaignsForSource = MarketoFactory::getInstance(true)->getCampaignsForSource(
                new ParamsGetCampaignsForSource(
                    $args['source'],
                    (empty($args['name'])) ? null : $args['name'],
                    (empty($args['exactName'])) ? false : filter_var($args['exactName'], FILTER_VALIDATE_BOOLEAN))
            );

            switch ($successGetCampaignsForSource->result->returnCount) {
                case 0:
                    return $data;
                case 1:
                    $successGetCampaignsForSource->result->campaignRecordList->campaignRecord = array($successGetCampaignsForSource->result->campaignRecordList->campaignRecord);
                default:
                    foreach ($successGetCampaignsForSource->result->campaignRecordList->campaignRecord as $campaignRecord) {
                        $data[] = array(
                            'id' => $campaignRecord->id,
                            'name' => $campaignRecord->name,
                            'description' => $campaignRecord->description
                        );
                    }
            }

            return $data;
        }
        throw new SugarApiException(ext_soap_marketo::SERVICE_NOT_ENABLED, null, null, 503);
    }

    /**
     * If we want to start the Marketo Synchronization from the start this method resets the starting point
     *
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function resetMarketo($api, $args)
    {
        global $timedate;

        if (!$api->user->isAdmin()) {
            throw new SugarApiExceptionNotAuthorized();
        }

        $administration = BeanFactory::getBean('Administration');
        $configs = array(
            'marketo',
            'marketo_activity_log'
        );

        foreach ($configs as $config) {
            $settings = $administration->getConfigForModule($config, null, true);

            foreach ($settings as $name => $value) {
                if ($name == 'remainingCount') {
                    $value = 0;
                } else {
                    $value = null;
                }
                $administration->saveSetting($config, $name, $value);
            }
        }

        return array('success' => true);
    }
}
