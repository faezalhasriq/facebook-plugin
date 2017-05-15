<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$dictionary['z_invoice_item'] = array(
    'table' => 'z_invoice_item',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array (
  'name' => 
  array (
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'dbType' => 'varchar',
    'len' => '255',
    'unified_search' => true,
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1.55',
      'searchable' => true,
    ),
    'required' => true,
    'importable' => 'required',
    'duplicate_merge' => 'enabled',
    'merge_filter' => 'selected',
    'duplicate_on_record_copy' => 'always',
    'massupdate' => false,
    'default' => '',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'duplicate_merge_dom_value' => '3',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'size' => '20',
  ),
  'description' => 
  array (
    'name' => 'description',
    'vname' => 'LBL_DESCRIPTION',
    'type' => 'text',
    'comment' => 'Full text of the note',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '0.5',
      'searchable' => true,
    ),
    'rows' => '6',
    'cols' => '80',
    'duplicate_on_record_copy' => 'always',
    'required' => false,
    'massupdate' => false,
    'default' => '',
    'no_default' => false,
    'comments' => 'Full text of the note',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'size' => '20',
    'studio' => 'visible',
  ),
  'item_amt' => 
  array (
    'required' => true,
    'name' => 'item_amt',
    'vname' => 'LBL_ITEM_AMT',
    'type' => 'decimal',
    'massupdate' => false,
    'default' => '0.00',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => '18',
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 2,
  ),
  'item_gst' => 
  array (
    'required' => true,
    'name' => 'item_gst',
    'vname' => 'LBL_ITEM_GST',
    'type' => 'decimal',
    'massupdate' => false,
    'default' => '0.06',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => '18',
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 2,
  ),
  'item_gst_amt' => 
  array (
    'required' => true,
    'name' => 'item_gst_amt',
    'vname' => 'LBL_ITEM_GST_AMT',
    'type' => 'decimal',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => 'true',
    'formula' => 'add($item_amt,$item_gst)',
    'enforced' => true,
    'len' => '18',
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 2,
  ),
  'item_amt_incl_gst' => 
  array (
    'required' => true,
    'name' => 'item_amt_incl_gst',
    'vname' => 'LBL_ITEM_AMT_INCL_GST',
    'type' => 'decimal',
    'massupdate' => false,
    'default' => '',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => '18',
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 2,
  ),
),
    'relationships' => array (
),
    'optimistic_locking' => true,
    'unified_search' => true,
    'full_text_search' => true,
);

if (!class_exists('VardefManager')){
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('z_invoice_item','z_invoice_item', array('basic','team_security','assignable','taggable'));