<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$module_name = 'ActivityLogs';
$subpanel_layout = array(
    'top_buttons' => array(),
    'where' => '',
    'list_fields' =>
        array(
            'name' =>
                array(
                    'vname' => 'LBL_NAME',
                    'widget_class' => 'SubPanelDetailViewLink',
                    'width' => '25%',
                    'sortable' => false,
                ),
            'description' =>
                array(
                    'width' => '45%',
                    'vname' => 'LBL_DESCRIPTION',
                    'sortable' => false,
                    'default' => true,
                ),
            'campaign_name' =>
                array(
                    'width' => '10%',
                    'vname' => 'LBL_CAMPAIGN_NAME',
                    'default' => true,
                    'sortable' => false,
                ),
            'date_modified' =>
                array(
                    'vname' => 'LBL_DATE_MODIFIED',
                    'width' => '15%',
                    'default' => true,
                ),
        ),
);
