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
$object_name = 'ActivityLogs';
$_module_name = 'activityLogs';
$popupMeta = array(
    'moduleMain' => $module_name,
    'varName' => $object_name,
    'orderBy' => $_module_name . '.name',
    'whereClauses' =>
        array(
            'name' => $_module_name . '.name',
        ),
    'searchInputs' => array($_module_name . '_number', 'name', 'priority', 'status'),

);
