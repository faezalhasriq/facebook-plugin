<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$config['name'] = 'Marketo';
$config['properties']['enabled'] = 2;
$config['properties']['marketo_wsdl'] = '';
$config['properties']['marketo_user_id'] = '';
$config['properties']['marketo_shared_secret'] = '';
$config['properties']['assigned_user_id'] = '1';
$config['properties']['download_score'] = '0';
$config['properties']['maximum_download'] = "unlimited";
$config['properties']['records_to_download'] = "100";
$config['properties']['filters'] =
    array(
        'FillOutForm',
        'InterestingMoment',
        'NewLead',
        'SendEmail',
        'EmailDelivered',
        'OpenEmail',
        'ClickLink'
    );
