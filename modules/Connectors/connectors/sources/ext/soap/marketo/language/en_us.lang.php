<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$connector_strings = array(
    //licensing information shown in config screen
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">&nbsp;</td><td width="65%" class="dataLabel">' .
        'Marketo provides marketing automation  and sales effectiveness solutions that help B2B marketing and sales teams at global enterprise and mid-sized companies unlock growth across the revenue cycle. Marketo\'s powerful on-demand solutions are easy to learn and use, meaning customers are successful faster without sacrificing the high-end functionality they need.' .
        '</td></tr>',
    //vardef labels
    'LBL_ADDRESS' => 'Address',
    'LBL_ANNUALREVENUE' => 'Annual Revenue',
    'LBL_ANONYMOUSIP' => 'Anonymous IP',
    'LBL_BILLINGCITY' => 'Billing City',
    'LBL_BILLINGCOUNTRY' => 'Billing Country',
    'LBL_BILLINGPOSTALCODE' => 'Billing Postal Code',
    'LBL_BILLINGSTATE' => 'Billing State',
    'LBL_BILLINGSTREET' => 'Billing Address',
    'LBL_CITY' => 'City',
    'LBL_COMPANY' => 'Company Name',
    'LBL_COUNTRY' => 'Country',
    'LBL_CREATED_ON' => 'Date Profile Created',
    'LBL_DATEOFBIRTH' => 'Date of Birth',
    'LBL_DONOTCALL' => 'Do Not Call',
    'LBL_DONOTCALLREASON' => 'Do Not Call Reason',
    'LBL_EMAIL' => 'Email Address',
    'LBL_EMPLOYEE_COUNT' => 'Employee Count',
    'LBL_EMPLOYEE_RANGE' => 'Headcount Range',
    'LBL_FAX' => 'Fax Number',
    'LBL_FIRSTNAME' => 'First Name',
    'LBL_INDUSTRY' => 'Industry',
    'LBL_INFERREDCOMPANY' => 'Inferred Company',
    'LBL_INFERREDCOUNTRY' => 'Inferred Country',
    'LBL_LASTNAME' => 'Last Name',
    'LBL_LEADROLE' => 'Role',
    'LBL_LEADSCORE' => 'Lead Score',
    'LBL_LEADSOURCE' => 'Lead Source',
    'LBL_LEADSTATUS' => 'Lead Status',
    'LBL_MAINPHONE' => 'Main Phone',
    'LBL_MIDDLENAME' => 'Middle Name',
    'LBL_MOBILEPHONE' => 'Mobile Phone Number',
    'LBL_NAME' => 'Name',
    'LBL_NUMBEROFEMPLOYEES' => 'Num Employees',
    'LBL_OWNERSHIP' => 'Ownership',
    'LBL_PHONE' => 'Phone Number',
    'LBL_POSTALCODE' => 'Postal Code',
    'LBL_RATING' => 'Lead Rating',
    'LBL_REMARKS' => 'Remarks',
    'LBL_REVENUE_RANGE' => 'Annual Revenue Estimate',
    'LBL_SALUTATION' => 'Salutation',
    'LBL_SICCODE' => 'SIC Code',
    'LBL_SITE' => 'Site',
    'LBL_STATE' => 'State',
    'LBL_TITLE' => 'Job Title',
    'LBL_UNSUBSCRIBED' => 'Unsubscribed',
    'LBL_UNSUBSCRIBEDREASON' => 'Unsubscribed Reason',
    'LBL_EMAILINVALID' => 'Email Invalid',
    'LBL_WEBSITE' => 'Website',
    'LBL_DEPARTMENT' => 'Department',
    'LBL_SUGARCRM_OWNER_FIRST_NAME' => 'SugarCRM Owner First Name',
    'LBL_SUGARCRM_OWNER_LAST_NAME' => 'SugarCRM Owner Last Name',
    'LBL_SUGARCRM_OWNER_PHONE' => 'SugarCRM Owner Phone',
    'LBL_SUGARCRM_OWNER_EMAIL' => 'SugarCRM Owner Email Address',
    'LBL_SUGARCRM_OWNER_TITLE' => 'SugarCRM Owner Title',
    'LBL_SUGARCRM_TYPE' => 'SugarCRM Record Type',
    'LBL_SUGARCRM_ID' => 'SugarCRM Record ID',
    //Configuration labels
    'range_end' => 'Maximum Number Of List Results',
    'marketo_wsdl' => 'SOAP Endpoint',
    'enabled' => 'Enable Marketo for SugarCRM',
    'marketo_api_key' => 'API Key',
    'marketo_user_id' => 'SOAP API User ID',
    'marketo_shared_secret' => 'SOAP API Encryption Key',
    'MARKETO_SHARED_SECRET_PLACEHOLDER' => 'SOAP API Encryption Key',
    'MARKETO_USER_ID_PLACEHOLDER' => 'SOAP API User ID',
    'MARKETO_WSDL_PLACEHOLDER' => 'https://478-TBR-139.mktoapi.com/soap/mktows/2_3',
    'assigned_user_id' => 'When a new SugarCRM Lead is created, whom should be the default Assigned To?',
    'convert_score' => 'Convert to Lead Score',
    'download_score' => 'Only download Marketo leads with a score greater than',
    'records_to_download' => 'How many records should we download from Marketo per batch',
    'get_details' => 'Download Activity Log Details',
    'keep_accounts_syncd' => 'When a Contacts Account changes do you want to keep it in sync?',
    'download_activity_log_by_default' => 'Download Activity Logs upon initial sync?',
    'filters' => 'Which Marketo Activity Logs should we download to SugarCRM?',
    'email_opt_out' => 'Would you like to keep SugarCRM <strong>Email Opt Out</strong> and Marketo <strong>Unsubscribed</strong> in sync?',
    'maximum_download' => 'How many <strong>lead records</strong> should we download each time synchronize occurs with Marketo?'
);
