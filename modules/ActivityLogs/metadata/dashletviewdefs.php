<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$dashletData['ActivityLogs']['searchFields'] = array(
    'date_entered' =>
        array(
            'default' => '',
        ),
    'date_modified' =>
        array(
            'default' => '',
        ),
    'team_id' =>
        array(
            'default' => '',
        ),
    'assigned_user_id' =>
        array(
            'type' => 'assigned_user_name',
            'default' => '',
        ),
);
$dashletData['ActivityLogs']['columns'] = array(
    'name' =>
        array(
            'width' => '40',
            'label' => 'LBL_LIST_NAME',
            'link' => true,
            'default' => true,
            'name' => 'name',
        ),
    'date_entered' =>
        array(
            'width' => '15',
            'label' => 'LBL_DATE_ENTERED',
            'default' => true,
            'name' => 'date_entered',
        ),
    'date_modified' =>
        array(
            'width' => '15',
            'label' => 'LBL_DATE_MODIFIED',
            'name' => 'date_modified',
        ),
    'created_by' =>
        array(
            'width' => '8',
            'label' => 'LBL_CREATED',
            'name' => 'created_by',
        ),
    'assigned_user_name' =>
        array(
            'width' => '8',
            'label' => 'LBL_LIST_ASSIGNED_USER',
            'name' => 'assigned_user_name',
        ),
);
