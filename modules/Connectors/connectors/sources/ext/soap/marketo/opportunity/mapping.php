<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

global $sugar_flavor;

$mapping = array(
    'beans' =>
        array(
            'Opportunities' =>
                array(
                    'amount' => 'amount_usdollar',
                    'closedate' => 'date_closed',
                    'description' => 'description',
                    'expectedrevenue' => 'mrkto2_expected_revenue_c',
                    'externalcreateddate' => 'date_entered',
                    'fiscalquarter' => 'mrkto2_fiscal_quarter_c',
                    'fiscalyear' => 'mrkto2_fiscal_year_c',
                    'forecastcategoryname' => 'mrkto2_forecastcategoryname_c',
                    'id' => 'mkto_id',
                    'isclosed' => 'mrkto2_is_closed_c',
                    'iswon' => 'mrkto2_is_won_c',
                    'lastactivitydate' => 'date_modified',
                    'leadsource' => 'lead_source',
                    'name' => 'name',
                    'nextstep' => 'next_step',
                    'probability' => 'probability',
                    'stage' => $sugar_flavor === 'CORP' ? 'sales_stage' : 'sales_status',
                    'type' => 'opportunity_type',
                ),
        ),
);