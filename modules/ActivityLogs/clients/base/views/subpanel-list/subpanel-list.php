<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

global $sugar_version;
$viewdefs['ActivityLogs']['base']['view']['subpanel-list'] = array(
    'favorite' => true,
    'rowactions' => array(
        'css_class' => 'pull-right',
        'actions' => array(
            array(
                'type' => 'rowaction',
                'css_class' => 'btn',
                'tooltip' => 'LBL_PREVIEW',
                'event' => 'list:preview:fire',
                'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? 'fa-eye' : 'icon-eye-open',
                'acl_action' => 'view',
            ),
        ),
    ),
    'panels' =>
        array(
            0 =>
                array(
                    'name' => 'panel_header',
                    'label' => 'LBL_PANEL_1',
                    'fields' =>
                        array(
                            0 =>
                                array(
                                    'name' => 'id',
                                    'label' => 'LBL_ID',
                                    'enabled' => true,
                                    'default' => true,
                                ),
                            1 =>
                                array(
                                    'label' => 'LBL_NAME',
                                    'enabled' => true,
                                    'default' => true,
                                    'name' => 'name',
                                    'link' => true,
                                ),
                            2 =>
                                array(
                                    'name' => 'description',
                                    'label' => 'LBL_DESCRIPTION',
                                    'enabled' => true,
                                    'sortable' => false,
                                    'default' => true,
                                ),
                            3 =>
                                array(
                                    'name' => 'campaign_name',
                                    'label' => 'LBL_CAMPAIGN_NAME',
                                    'enabled' => true,
                                    'default' => true,
                                ),
                            4 =>
                                array(
                                    'label' => 'LBL_DATE_MODIFIED',
                                    'enabled' => true,
                                    'default' => true,
                                    'name' => 'date_modified',
                                ),
                        ),
                ),
        ),
    'orderBy' =>
        array(
            'field' => 'date_modified',
            'direction' => 'desc',
        ),
    'type' => 'subpanel-list',
);
