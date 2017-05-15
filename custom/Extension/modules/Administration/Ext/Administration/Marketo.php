<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/
$admin_option_defs = array();
$admin_option_defs['Administration']['info'] =
    array(
        'ActivityLogs',
        'LBL_MARKETO_INFO_TITLE',
        'LBL_MARKETO_INFO_DESC',
        'javascript:parent.SUGAR.App.router.navigate("ActivityLogs/layout/marketo-information", {trigger: true});'
    );

$admin_option_defs['Administration']['schema'] =
    array(
        'ActivityLogs',
        'LBL_MARKETO_SCHEMA_TITLE',
        'LBL_MARKETO_SCHEMA_DESC',
        'javascript:parent.SUGAR.App.router.navigate("ActivityLogs/layout/marketo-schema", {trigger: true});'
    );

$admin_option_defs['Administration']['marketo_config'] =
    array(
        'ActivityLogs',
        'LBL_MARKETO_TITLE',
        'LBL_MARKETO_DESC',
        'javascript:parent.SUGAR.App.router.navigate("ActivityLogs/layout/marketo-reset", {trigger: true});'
    );

$exists = false;
$count = 0;
foreach ($admin_group_header as $header) {
    if ($header[0] == 'LBL_MARKETO_CONFIG_TITLE') {
        $exists = true;
        break;
    }
    $count++;
}

$admin_group_header[($exists) ? $count : ""] = array('LBL_MARKETO_CONFIG_TITLE', '', false, $admin_option_defs);
?>
