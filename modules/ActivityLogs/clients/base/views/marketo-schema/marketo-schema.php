<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

global $sugar_version;
$viewdefs['ActivityLogs']['base']['view']['marketo-schema'] = array(
    'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? "fa fa-spinner fa-spin fa-large" : "icon-spinner icon-spin icon-large",
);
