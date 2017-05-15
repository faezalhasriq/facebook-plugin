<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

global $sugar_version;
$moduleName = 'ActivityLogs';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'route' => "#$moduleName",
        'label' => 'LNK_LIST',
        'acl_action' => 'list',
        'acl_module' => $moduleName,
        'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? 'fa-reorder' : 'icon-reorder',
    ),
    array(
        'route' => "#$moduleName/layout/marketo-schema",
        'label' => 'LBL_DOWNLOAD_CUSTOM_FIELDS',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? 'fa-download' : 'icon-download',
    ),
    array(
        'route' => "#$moduleName/layout/marketo-information",
        'label' => 'LBL_DISPLAY_SYNCHRONIZATION_INFORMATION',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? 'fa-dashboard' : 'icon-dashboard',
    ),
    array(
        'route' => "#$moduleName/layout/marketo-reset",
        'label' => 'LBL_RESTART',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? 'fa-magic' : 'icon-magic',
    ),
);