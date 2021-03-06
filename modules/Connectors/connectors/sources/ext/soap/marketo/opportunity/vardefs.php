<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$dictionary["ext_soap_marketo_opportunity"] = array(
    'comment' => 'vardefs for marketo connector',
    'fields' =>
        array(
            'amount' =>
                array(
                    'name' => 'amount',
                    'marketo' => 'Amount',
                    'vname' => 'LBL_AMOUNT',
                    'type' => 'currency',
                    'displayName' => 'Amount',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'closedate' =>
                array(
                    'name' => 'closedate',
                    'marketo' => 'CloseDate',
                    'vname' => 'LBL_CLOSEDATE',
                    'type' => 'date',
                    'displayName' => 'Close Date',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'companyid' =>
                array(
                    'name' => 'companyid',
                    'marketo' => 'CompanyId',
                    'vname' => 'LBL_COMPANYID',
                    'type' => 'reference',
                    'displayName' => 'Account',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'description' =>
                array(
                    'name' => 'description',
                    'marketo' => 'Description',
                    'vname' => 'LBL_DESCRIPTION',
                    'type' => 'varchar',
                    'displayName' => 'Description',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => 2000,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'expectedrevenue' =>
                array(
                    'name' => 'expectedrevenue',
                    'marketo' => 'ExpectedRevenue',
                    'vname' => 'LBL_EXPECTEDREVENUE',
                    'type' => 'currency',
                    'displayName' => 'Expected Revenue',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'externalcreateddate' =>
                array(
                    'name' => 'externalcreateddate',
                    'marketo' => 'ExternalCreatedDate',
                    'vname' => 'LBL_EXTERNALCREATEDDATE',
                    'type' => 'datetime',
                    'displayName' => 'SFDC Created Date',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'fiscal' =>
                array(
                    'name' => 'fiscal',
                    'marketo' => 'Fiscal',
                    'vname' => 'LBL_FISCAL',
                    'type' => 'varchar',
                    'displayName' => 'Fiscal',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => 255,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'fiscalquarter' =>
                array(
                    'name' => 'fiscalquarter',
                    'marketo' => 'FiscalQuarter',
                    'vname' => 'LBL_FISCALQUARTER',
                    'type' => 'int',
                    'displayName' => 'Fiscal Quarter',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'fiscalyear' =>
                array(
                    'name' => 'fiscalyear',
                    'marketo' => 'FiscalYear',
                    'vname' => 'LBL_FISCALYEAR',
                    'type' => 'int',
                    'displayName' => 'Fiscal Year',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'forecastcategoryname' =>
                array(
                    'name' => 'forecastcategoryname',
                    'marketo' => 'ForecastCategoryName',
                    'vname' => 'LBL_FORECASTCATEGORYNAME',
                    'type' => 'varchar',
                    'displayName' => 'Forecast Category Name',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => 255,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'id' =>
                array(
                    'name' => 'id',
                    'marketo' => 'Id',
                    'vname' => 'LBL_ID',
                    'type' => 'int',
                    'displayName' => 'Id',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => true,
                    'dynamicFieldRef' => 'attributeList',
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'isclosed' =>
                array(
                    'name' => 'isclosed',
                    'marketo' => 'IsClosed',
                    'vname' => 'LBL_ISCLOSED',
                    'type' => 'boolean',
                    'displayName' => 'Is Closed',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'iswon' =>
                array(
                    'name' => 'iswon',
                    'marketo' => 'IsWon',
                    'vname' => 'LBL_ISWON',
                    'type' => 'boolean',
                    'displayName' => 'Is Won',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'lastactivitydate' =>
                array(
                    'name' => 'lastactivitydate',
                    'marketo' => 'LastActivityDate',
                    'vname' => 'LBL_LASTACTIVITYDATE',
                    'type' => 'date',
                    'displayName' => 'Last Activity Date',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'leadsource' =>
                array(
                    'name' => 'leadsource',
                    'marketo' => 'LeadSource',
                    'vname' => 'LBL_LEADSOURCE',
                    'type' => 'varchar',
                    'displayName' => 'Lead Source',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => 255,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'name' =>
                array(
                    'name' => 'name',
                    'marketo' => 'Name',
                    'vname' => 'LBL_NAME',
                    'type' => 'varchar',
                    'displayName' => 'Name',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => 255,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'nextstep' =>
                array(
                    'name' => 'nextstep',
                    'marketo' => 'NextStep',
                    'vname' => 'LBL_NEXTSTEP',
                    'type' => 'varchar',
                    'displayName' => 'Next Step',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => 255,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'probability' =>
                array(
                    'name' => 'probability',
                    'marketo' => 'Probability',
                    'vname' => 'LBL_PROBABILITY',
                    'type' => 'int',
                    'displayName' => 'Probability',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'quantity' =>
                array(
                    'name' => 'quantity',
                    'marketo' => 'Quantity',
                    'vname' => 'LBL_QUANTITY',
                    'type' => 'float',
                    'displayName' => 'Quantity',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => null,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'stage' =>
                array(
                    'name' => 'stage',
                    'marketo' => 'Stage',
                    'vname' => 'LBL_STAGE',
                    'type' => 'varchar',
                    'displayName' => 'Stage',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => 255,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
            'type' =>
                array(
                    'name' => 'type',
                    'marketo' => 'Type',
                    'vname' => 'LBL_TYPE',
                    'type' => 'varchar',
                    'displayName' => 'Type',
                    'description' => null,
                    'sourceObject' => 'Opportunity',
                    'size' => 255,
                    'isReadonly' => false,
                    'isUpdateBlocked' => false,
                    'isName' => null,
                    'isPrimaryKey' => false,
                    'isCustom' => false,
                    'isDynamic' => false,
                    'dynamicFieldRef' => null,
                    'updatedAt' => '2013-04-15T15:15:46-05:00',
                ),
        ),
);
