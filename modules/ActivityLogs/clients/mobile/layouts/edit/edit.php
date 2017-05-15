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
$viewdefs[$module_name]['mobile']['layout']['edit'] = array(
    'type' => 'edit',
    'components' =>
        array(
            0 =>
                array(
                    'view' => 'edit',
                )
        ),
);