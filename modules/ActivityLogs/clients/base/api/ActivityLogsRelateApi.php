<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once('clients/base/api/RelateApi.php');
require_once('include/externalAPI/Marketo/MarketoFactory.php');

class  ActivityLogsRelateApi extends RelateApi
{

    /**
     * Setup the endpoint that belong to this API EndPoint
     *
     * @return array
     */
    public function registerApiRest()
    {
        return array(
            'listRelatedRecords' => array(
                'reqType' => 'GET',
                'path' => array('<module>', '?', 'link', 'activity_logs'),
                'pathVars' => array('module', 'record', ''),
                'jsonParams' => array('filter'),
                'method' => 'filterRelated',
                'shortHelp' => '',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
        );
    }

    /**
     * Display the most up to date information in the Activity Logs SubPanel
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function filterRelated(ServiceBase $api, array $args)
    {

        $api->action = 'list';
        $args['link_name'] = 'activity_logs';

        list($args, $q, $options, $linkSeed) = $this->filterRelatedSetup($api, $args);

        return $this->runQuery($api, $args, $q, $options, $linkSeed);
    }

}
