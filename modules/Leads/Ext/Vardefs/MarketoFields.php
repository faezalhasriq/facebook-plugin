<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

// Marketo Fields
$dictionary['Lead']['fields']['mkto_sync'] =
    array(
        'name' => 'mkto_sync',
        'vname' => 'LBL_MKTO_SYNC',
        'type' => 'bool',
        'default' => '0',
        'comment' => 'Should the Lead be synced to Marketo',
        'massupdate' => true,
        'audited' => true,
        'duplicate_merge' => true,
        'reportable' => true,
        'importable' => 'true',
    );

$dictionary['Lead']['fields']['mkto_id'] =
    array(
        'name' => 'mkto_id',
        'vname' => 'LBL_MKTO_ID',
        'audited' => true,
        'calculated' => false,
        'comment' => 'Associated Marketo Lead ID',
        'default' => null,
        'disable_num_format' => true,
        'duplicate_merge' => true,
        'enable_range_search' => true,
        'full_text_search' =>
            array(
                'boost' => 3,
            ),
        'importable' => 'false',
        'mass_update' => false,
        'max' => false,
        'merge_filter' => 'disabled',
        'min' => false,
        'options' => 'numeric_range_search_dom',
        'readonly' => true,
        'reportable' => true,
        'type' => 'int',
        'unified_search' => true,
        'duplicate_on_record_copy' => 'no',
    );

$dictionary['Lead']['fields']['mkto_lead_score'] =
    array(
        'name' => 'mkto_lead_score',
        'vname' => 'LBL_MKTO_LEAD_SCORE',
        'comment' => null,
        'type' => 'int',
        'default_value' => null,
        'audited' => true,
        'mass_update' => false,
        'duplicate_merge' => true,
        'reportable' => true,
        'importable' => 'true',
        'readonly' => true,
        'duplicate_on_record_copy' => 'no',
    );