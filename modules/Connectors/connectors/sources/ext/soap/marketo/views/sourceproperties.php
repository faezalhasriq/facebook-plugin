<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

global $app_list_strings;


$yes_no =
    array(
        '1' => 'Yes',
        '2' => 'No'
    );

$mkto['enabled'] = get_select_options_with_id($yes_no, isset($properties['enabled']) ? $properties['enabled'] : 1);
$mkto['assigned_user_id'] = get_select_options_with_id(
    get_user_array(false),
    isset($properties['assigned_user_id']) ? $properties['assigned_user_id'] : ''
);
$mkto['maximum_download'] = get_select_options_with_id(
    $app_list_strings['mkto_maximum_download_list'],
    (isset($properties['maximum_download'])) ? $properties['maximum_download'] : "unlimited"
);
$mkto['records_to_download'] = get_select_options_with_id(
    $app_list_strings['mkto_download_records'],
    (isset($properties['records_to_download'])) ? $properties['records_to_download'] : "100"
);

$filter = get_select_options_with_id(
    $app_list_strings['mkto_activity_type'],
    isset($properties['filters']) ? $properties['filters'] : ''
);
$this->ss->assign('mkto', $mkto);
$this->ss->assign('filter', $filter);