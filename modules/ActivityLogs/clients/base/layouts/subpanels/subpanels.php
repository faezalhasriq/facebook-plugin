<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
$viewdefs['ActivityLogs']['base']['layout']['subpanels'] = array(
    'components' => array(
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_LEADS_TITLE',
            'context' => array(
                'link' => 'leads',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_CONTACTS_TITLE',
            'context' => array(
                'link' => 'contacts',
            ),
        ),
    ),
    'type' => 'subpanels',
    'span' => 12,
);
