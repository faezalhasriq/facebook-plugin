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

$dictionary['zzz_lot'] = array(
    'table' => 'zzz_lot',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array (
  'lot_code' => 
  array (
    'required' => false,
    'name' => 'lot_code',
    'vname' => 'LBL_LOT_CODE',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_bumi_lot' => 
  array (
    'required' => false,
    'name' => 'lot_bumi_lot',
    'vname' => 'LBL_LOT_BUMI_LOT',
    'type' => 'bool',
    'massupdate' => false,
    'default' => false,
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
    'len' => '255',
    'size' => '20',
  ),
  'lot_address_street' => 
  array (
    'required' => false,
    'name' => 'lot_address_street',
    'vname' => 'LBL_LOT_ADDRESS_STREET',
    'type' => 'text',
    'massupdate' => false,
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
    'len' => 150,
    'size' => '20',
    'group' => 'lot_address',
    'dbType' => 'varchar',
    'default' => '',
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'studio' => 'visible',
    'rows' => '4',
    'cols' => '20',
  ),
  'lot_address_city' => 
  array (
    'required' => false,
    'name' => 'lot_address_city',
    'vname' => 'LBL_LOT_ADDRESS_CITY',
    'type' => 'varchar',
    'massupdate' => false,
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
    'len' => '100',
    'size' => '20',
    'group' => 'lot_address',
    'default' => '',
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
  ),
  'lot_address_state' => 
  array (
    'required' => false,
    'name' => 'lot_address_state',
    'vname' => 'LBL_LOT_ADDRESS_STATE',
    'type' => 'varchar',
    'massupdate' => false,
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
    'len' => '100',
    'size' => '20',
    'group' => 'lot_address',
    'default' => '',
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
  ),
  'lot_address_postalcode' => 
  array (
    'required' => false,
    'name' => 'lot_address_postalcode',
    'vname' => 'LBL_LOT_ADDRESS_POSTALCODE',
    'type' => 'varchar',
    'massupdate' => false,
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
    'len' => '20',
    'size' => '20',
    'group' => 'lot_address',
    'default' => '',
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
  ),
  'lot_address_country' => 
  array (
    'required' => false,
    'name' => 'lot_address_country',
    'vname' => 'LBL_LOT_ADDRESS_COUNTRY',
    'type' => 'varchar',
    'massupdate' => false,
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
    'len' => '100',
    'size' => '20',
    'group' => 'lot_address',
    'default' => '',
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
  ),
  'lot_management_reserve' => 
  array (
    'required' => false,
    'name' => 'lot_management_reserve',
    'vname' => 'LBL_LOT_MANAGEMENT_RESERVE',
    'type' => 'bool',
    'massupdate' => false,
    'default' => false,
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
    'len' => '255',
    'size' => '20',
  ),
  'lot_booking_remark' => 
  array (
    'required' => false,
    'name' => 'lot_booking_remark',
    'vname' => 'LBL_LOT_BOOKING_REMARK',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_hsd_no' => 
  array (
    'required' => false,
    'name' => 'lot_hsd_no',
    'vname' => 'LBL_LOT_HSD_NO',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_ptd_no' => 
  array (
    'required' => false,
    'name' => 'lot_ptd_no',
    'vname' => 'LBL_LOT_PTD_NO',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_unit_measure' => 
  array (
    'required' => false,
    'name' => 'lot_unit_measure',
    'vname' => 'LBL_LOT_UNIT_MEASURE',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_position' => 
  array (
    'required' => false,
    'name' => 'lot_position',
    'vname' => 'LBL_LOT_POSITION',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_direction' => 
  array (
    'required' => false,
    'name' => 'lot_direction',
    'vname' => 'LBL_LOT_DIRECTION',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_building_type' => 
  array (
    'required' => false,
    'name' => 'lot_building_type',
    'vname' => 'LBL_LOT_BUILDING_TYPE',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_building_design' => 
  array (
    'required' => false,
    'name' => 'lot_building_design',
    'vname' => 'LBL_LOT_BUILDING_DESIGN',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_block' => 
  array (
    'required' => false,
    'name' => 'lot_block',
    'vname' => 'LBL_LOT_BLOCK',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_level' => 
  array (
    'required' => false,
    'name' => 'lot_level',
    'vname' => 'LBL_LOT_LEVEL',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_view_type' => 
  array (
    'required' => false,
    'name' => 'lot_view_type',
    'vname' => 'LBL_LOT_VIEW_TYPE',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_finishing' => 
  array (
    'required' => false,
    'name' => 'lot_finishing',
    'vname' => 'LBL_LOT_FINISHING',
    'type' => 'varchar',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'lot_tax_exclude' => 
  array (
    'required' => false,
    'name' => 'lot_tax_exclude',
    'vname' => 'LBL_LOT_TAX_EXCLUDE',
    'type' => 'bool',
    'massupdate' => false,
    'default' => false,
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
    'len' => '255',
    'size' => '20',
  ),
  'lot_handover_date' => 
  array (
    'required' => false,
    'name' => 'lot_handover_date',
    'vname' => 'LBL_LOT_HANDOVER_DATE',
    'type' => 'date',
    'massupdate' => true,
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
    'size' => '20',
    'enable_range_search' => false,
  ),
  'lot_status' => 
  array (
    'required' => false,
    'name' => 'lot_status',
    'vname' => 'LBL_LOT_STATUS',
    'type' => 'enum',
    'massupdate' => true,
    'default' => 'available',
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
    'len' => 100,
    'size' => '20',
    'options' => 'lot_status_list',
    'dependency' => false,
  ),
  'lot_bumi_release' => 
  array (
    'required' => false,
    'name' => 'lot_bumi_release',
    'vname' => 'LBL_LOT_BUMI_RELEASE',
    'type' => 'int',
    'massupdate' => false,
    'default' => '0',
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
    'full_text_search' => 
    array (
      'enabled' => '0',
      'boost' => '1',
      'searchable' => false,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
  ),
  'lot_booking_date' => 
  array (
    'required' => false,
    'name' => 'lot_booking_date',
    'vname' => 'LBL_LOT_BOOKING_DATE',
    'type' => 'date',
    'massupdate' => true,
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
    'size' => '20',
    'enable_range_search' => false,
  ),
  'lot_buildup_area' => 
  array (
    'required' => false,
    'name' => 'lot_buildup_area',
    'vname' => 'LBL_LOT_BUILDUP_AREA',
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
    'precision' => 4,
  ),
  'lot_land_area' => 
  array (
    'required' => false,
    'name' => 'lot_land_area',
    'vname' => 'LBL_LOT_LAND_AREA',
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
    'precision' => 4,
  ),
  'lot_list_price' => 
  array (
    'required' => false,
    'name' => 'lot_list_price',
    'vname' => 'LBL_LOT_LIST_PRICE',
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
  'lot_total_amt' => 
  array (
    'required' => false,
    'name' => 'lot_total_amt',
    'vname' => 'LBL_LOT_TOTAL_AMT',
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
    'precision' => 4,
  ),
  'lot_est_selling_prc' => 
  array (
    'required' => false,
    'name' => 'lot_est_selling_prc',
    'vname' => 'LBL_LOT_EST_SELLING_PRC',
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
VardefManager::createVardef('zzz_lot','zzz_lot', array('basic','team_security','assignable','taggable'));