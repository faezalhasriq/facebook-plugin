<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$viewdefs['ActivityLogs']['base']['filter']['default'] = array(
    'default_filter' => 'all_records',
    'fields' =>
        array(
            'name' =>
                array(),
            '$owner' =>
                array(
                    'predefined_filter' => true,
                    'vname' => 'LBL_CURRENT_USER_FILTER',
                ),
            '$favorite' =>
                array(
                    'predefined_filter' => true,
                    'vname' => 'LBL_FAVORITES_FILTER',
                ),
            'campaign_name' =>
                array(),
            'mkto_id' =>
                array(),
        ),
);