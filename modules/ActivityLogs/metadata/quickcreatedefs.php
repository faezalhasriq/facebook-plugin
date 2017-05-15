<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$module_name = 'ActivityLogs';
$viewdefs[$module_name]['QuickCreate'] = array(
    'templateMeta' => array(
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
    ),
    'panels' => array(
        'default' =>
            array(

                array(
                    'name',
                    'assigned_user_name',
                ),
                array(
                    'description',
                    array('name' => 'team_name', 'displayParams' => array('display' => true)),
                ),
            ),

    ),

);
?>