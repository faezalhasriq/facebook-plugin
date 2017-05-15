<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/
$viewdefs['Contacts']['base']['layout']['subpanels']['components'][] =
    array(
        'layout' => 'subpanel',
        'label' => 'LBL_ACTIVITY_LOGS_TITLE',
        'context' => array(
            'link' => 'activity_logs',
            'override_subpanel_list_view' => 'subpanel-for-leads',
        ),
    );
