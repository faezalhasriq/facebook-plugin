<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

global $sugar_version;
$viewdefs['ActivityLogs']['base']['view']['panel-top'] = array(
    'buttons' => array(
        array(
            'type' => 'button',
            'css_class' => 'btn-invisible',
            'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? 'fa-chevron-up' : 'icon-chevron-up',
        ),
        array(
            'type' => 'actiondropdown',
            'name' => 'panel_dropdown',
            'css_class' => 'pull-right',
            'buttons' => array(
                array(
                    'type' => 'sticky-rowaction',
                    'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? 'fa-plus' : 'icon-plus',
                    'name' => 'create_button',
                    'label' => ' ',
                    'acl_action' => 'create',
                    'css_class' => 'disabled',
                    'tooltip' => 'LBL_CREATE_BUTTON_LABEL',
                ),
                array(
                    'type' => 'sticky-rowaction',
                    'name' => 'select_button',
                    'label' => 'LBL_ASSOC_RELATED_RECORD',
                    'icon' => version_compare($sugar_version, '7.6.0') >= 0 ? 'fa-pencil' : 'icon-pencil',
                    'css_class' => 'disabled',
                ),
            ),
        ),
    ),

);
