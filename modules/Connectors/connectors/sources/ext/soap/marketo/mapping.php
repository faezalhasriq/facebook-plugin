<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$mapping = array(
    'beans' =>
        array(
            'Leads' =>
                array(
                    'salutation' => 'salutation',
                    'firstname' => 'first_name',
                    'lastname' => 'last_name',
                    'title' => 'title',
                    'email' => 'email',
                    'company' => 'account_name',
                    'address' => 'primary_address_street',
                    'city' => 'primary_address_city',
                    'state' => 'primary_address_state',
                    'postalcode' => 'primary_address_postalcode',
                    'country' => 'primary_address_country',
                    'phone' => 'phone_work',
                    'mobilephone' => 'phone_mobile',
                    'fax' => 'phone_fax',
                    'dateofbirth' => 'birthdate',
                    'leadscore' => 'mkto_lead_score',
                    'donotcall' => 'do_not_call',
                    'leadstatus' => 'status',
                    'leadsource' => 'lead_source',
                    'website' => 'website',
                    'department' => 'department',
                    'annualrevenue' => 'mrkto2_annualrevenue_c',
                    'anonymousip' => 'mrkto2_anonymousip_c',
                    'donotcallreason' => 'mrkto2_do_not_call_reason_c',
                    'industry' => 'mrkto2_industry_c',
                    'inferredcompany' => 'mrkto2_inferred_company_c',
                    'inferredcountry' => 'mrkto2_inferred_country_c',
                    'leadrole' => 'mrkto2_role_c',
                    'middlename' => 'mrkto2_middle_name_c',
                    'mainphone' => 'mrkto2_main_phone_c',
                    'numberofemployees' => 'mrkto2_number_of_employees_c',
                    'rating' => 'mrkto2_rating_c',
                    'siccode' => 'mrkto2_sic_code_c',
                    'site' => 'mrkto2_site_c',
                    'unsubscribed' => 'mrkto2_unsubscribed_c',
                    'unsubscribedreason' => 'mrkto2_unsubscribed_reason_c',
                    'emailinvalid' => 'invalid_email',
                ),
            'Contacts' =>
                array(
                    'salutation' => 'salutation',
                    'firstname' => 'first_name',
                    'lastname' => 'last_name',
                    'title' => 'title',
                    'email' => 'email',
                    'address' => 'primary_address_street',
                    'city' => 'primary_address_city',
                    'state' => 'primary_address_state',
                    'postalcode' => 'primary_address_postalcode',
                    'country' => 'primary_address_country',
                    'phone' => 'phone_work',
                    'mobilephone' => 'phone_mobile',
                    'fax' => 'phone_fax',
                    'dateofbirth' => 'birthdate',
                    'donotcall' => 'do_not_call',
                    'leadsource' => 'lead_source',
                    'leadscore' => 'mkto_lead_score',
                    'department' => 'department',
                    'anonymousip' => 'mrkto2_anonymousip_c',
                    'donotcallreason' => 'mrkto2_do_not_call_reason_c',
                    'inferredcompany' => 'mrkto2_inferred_company_c',
                    'inferredcountry' => 'mrkto2_inferred_country_c',
                    'leadrole' => 'mrkto2_role_c',
                    'middlename' => 'mrkto2_middle_name_c',
                    'rating' => 'mrkto2_rating_c',
                    'site' => 'mrkto2_site_c',
                    'unsubscribed' => 'mrkto2_unsubscribed_c',
                    'unsubscribedreason' => 'mrkto2_unsubscribed_reason_c',
                    'emailinvalid' => 'invalid_email',
                ),
            'Accounts' =>
                array(
                    'company' => 'name',
                    'billingstreet' => 'billing_address_street',
                    'billingcity' => 'billing_address_city',
                    'billingstate' => 'billing_address_state',
                    'billingpostalcode' => 'billing_address_postalcode',
                    'billingcountry' => 'billing_address_country',
                    'siccode' => 'sic_code',
                    'mainphone' => 'phone_office',
                    'industry' => 'industry',
                    'annualrevenue' => 'annual_revenue',
                    'numberofemployees' => 'employees',
                    'website' => 'website',
                ),
            'Users' =>
                array(
                    'sugarcrm_owner_email' => 'email1',
                    'sugarcrm_owner_first_name' => 'first_name',
                    'sugarcrm_owner_last_name' => 'last_name',
                    'sugarcrm_owner_phone' => 'phone_work',
                    'sugarcrm_owner_title' => 'title'
                ),
        )
);
