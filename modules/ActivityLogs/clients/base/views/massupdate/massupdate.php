<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

global $sugar_version;
$module_name = 'ActivityLogs';
$viewdefs[$module_name]['base']['view']['massupdate'] = array(
    'buttons' => array(
        array(
            'name' => 'update_button',
            'type' => 'button',
            'label' => 'Update',
            'acl_action' => 'massupdate',
            'css_class' => 'btn-primary',
            'primary' => true,
        ),
        array(
            'type' => 'button',
            'value' => 'cancel',
            'css_class' => 'btn-invisible cancel_button',
            'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? 'fa-remove' : 'icon-remove',
            'primary' => false,
        ),
    ),
    'panels' =>
        array(
            array(
                'fields' => array()
            )
        )
);
