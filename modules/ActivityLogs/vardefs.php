<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$dictionary['ActivityLog'] = array(
    'table' => 'activity_logs',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array(
        'campaign_name' =>
            array(
                'required' => false,
                'name' => 'campaign_name',
                'vname' => 'LBL_CAMPAIGN_NAME',
                'type' => 'varchar',
                'massupdate' => false,
                'no_default' => false,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'full_text_search' =>
                    array(
                        'boost' => '0',
                    ),
                'calculated' => false,
                'len' => '255',
                'size' => '20',
            ),
        'mkto_id' =>
            array(
                'name' => 'mkto_id',
                'vname' => 'LBL_MKTO_ID',
                'comments' => null,
                'help' => null,
                'type' => 'int',
                'require_option' => '0',
                'default_value' => null,
                'deleted' => '0',
                'audited' => true,
                'mass_update' => '0',
                'duplicate_merge' => '0',
                'reportable' => '1',
                'importable' => 'false',
                'enable_range_search' => '1',
                'min' => false,
                'max' => false,
                'disable_num_format' => '1',
                'merge_filter' => 'disabled',
                'options' => 'numeric_range_search_dom',
                'duplicate_merge_dom_value' => '0',
            ),
        'leads' =>
            array(
                'name' => 'leads',
                'type' => 'link',
                'relationship' => 'activitylogs_leads',
                'vname' => 'LBL_LEADS',
                'link_type' => 'many',
                'module' => 'Leads',
                'bean_name' => 'Lead',
                'source' => 'non-db',
            ),
        'contacts' =>
            array(
                'vname' => 'LBL_CONTACTS',
                'name' => 'contacts',
                'type' => 'link',
                'relationship' => 'activitylogs_contacts',
                'link_type' => 'many',
                'module' => 'Contacts',
                'bean_name' => 'Contact',
                'source' => 'non-db',
            ),
    ),
    'relationships' =>
        array(
            'activitylogs_leads' =>
                array(
                    'lhs_module' => 'Leads',
                    'lhs_table' => 'leads',
                    'lhs_key' => 'mkto_id',
                    'rhs_module' => 'ActivityLogs',
                    'rhs_table' => 'activity_logs',
                    'rhs_key' => 'mkto_id',
                    'relationship_type' => 'one-to-many',
                ),
            'activitylogs_contacts' =>
                array(
                    'lhs_module' => 'Contacts',
                    'lhs_table' => 'contacts',
                    'lhs_key' => 'mkto_id',
                    'rhs_module' => 'ActivityLogs',
                    'rhs_table' => 'activity_logs',
                    'rhs_key' => 'mkto_id',
                    'relationship_type' => 'one-to-many',
                ),
        ),
    'optimistic_locking' => true,
    'unified_search' => false,
    'indices' => array(
        array('name' => 'activity_logs_mkto_id_deleted', 'type' => 'index', 'fields' => array('mkto_id', 'deleted')),
    ),
);
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('ActivityLogs', 'ActivityLog', array('basic'));

$dictionary['ActivityLog']['fields']['id']['studio'] = true;
