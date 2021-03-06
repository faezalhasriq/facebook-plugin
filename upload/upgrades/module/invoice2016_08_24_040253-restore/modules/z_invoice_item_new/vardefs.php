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

$dictionary['z_invoice_item_new'] = array(
    'table' => 'z_invoice_item_new',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array (
  'item_entity_cd' => 
  array (
    'required' => true,
    'name' => 'item_entity_cd',
    'vname' => 'LBL_ITEM_ENTITY_CD',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_project_no' => 
  array (
    'required' => true,
    'name' => 'item_project_no',
    'vname' => 'LBL_ITEM_PROJECT_NO',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_trx_type' => 
  array (
    'required' => false,
    'name' => 'item_trx_type',
    'vname' => 'LBL_ITEM_TRX_TYPE',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_debtor_acct' => 
  array (
    'required' => true,
    'name' => 'item_debtor_acct',
    'vname' => 'LBL_ITEM_DEBTOR_ACCT',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_doc_no' => 
  array (
    'required' => true,
    'name' => 'item_doc_no',
    'vname' => 'LBL_ITEM_DOC_NO',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_descs_1' => 
  array (
    'required' => false,
    'name' => 'item_descs_1',
    'vname' => 'LBL_ITEM_DESCS_1',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_currency_cd' => 
  array (
    'required' => true,
    'name' => 'item_currency_cd',
    'vname' => 'LBL_ITEM_CURRENCY_CD',
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
  'item_audit_user' => 
  array (
    'required' => true,
    'name' => 'item_audit_user',
    'vname' => 'LBL_ITEM_AUDIT_USER',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_ref_no' => 
  array (
    'required' => false,
    'name' => 'item_ref_no',
    'vname' => 'LBL_ITEM_REF_NO',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_sequence' => 
  array (
    'required' => false,
    'name' => 'item_sequence',
    'vname' => 'LBL_ITEM_SEQUENCE',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_prefix' => 
  array (
    'required' => true,
    'name' => 'item_prefix',
    'vname' => 'LBL_ITEM_PREFIX',
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
  'item_lot_no' => 
  array (
    'required' => false,
    'name' => 'item_lot_no',
    'vname' => 'LBL_ITEM_LOT_NO',
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
  'item_grace_period' => 
  array (
    'required' => false,
    'name' => 'item_grace_period',
    'vname' => 'LBL_ITEM_GRACE_PERIOD',
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
  'item_business_id' => 
  array (
    'required' => true,
    'name' => 'item_business_id',
    'vname' => 'LBL_ITEM_BUSINESS_ID',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_contact_person' => 
  array (
    'required' => false,
    'name' => 'item_contact_person',
    'vname' => 'LBL_ITEM_CONTACT_PERSON',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_contact_telno' => 
  array (
    'required' => false,
    'name' => 'item_contact_telno',
    'vname' => 'LBL_ITEM_CONTACT_TELNO',
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
  'item_giro_acctno' => 
  array (
    'required' => false,
    'name' => 'item_giro_acctno',
    'vname' => 'LBL_ITEM_GIRO_ACCTNO',
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
  'item_descs_2' => 
  array (
    'required' => false,
    'name' => 'item_descs_2',
    'vname' => 'LBL_ITEM_DESCS_2',
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
  'item_bank_cd' => 
  array (
    'required' => false,
    'name' => 'item_bank_cd',
    'vname' => 'LBL_ITEM_BANK_CD',
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
  'item_fbase_amt' => 
  array (
    'required' => true,
    'name' => 'item_fbase_amt',
    'vname' => 'LBL_ITEM_FBASE_AMT',
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
  'item_ftax_amt' => 
  array (
    'required' => true,
    'name' => 'item_ftax_amt',
    'vname' => 'LBL_ITEM_FTAX_AMT',
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
  'item_descs_3' => 
  array (
    'required' => false,
    'name' => 'item_descs_3',
    'vname' => 'LBL_ITEM_DESCS_3',
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
  'item_descs_4' => 
  array (
    'required' => false,
    'name' => 'item_descs_4',
    'vname' => 'LBL_ITEM_DESCS_4',
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
  'item_fdoc_amt' => 
  array (
    'required' => true,
    'name' => 'item_fdoc_amt',
    'vname' => 'LBL_ITEM_FDOC_AMT',
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
  'item_trx_amt' => 
  array (
    'required' => true,
    'name' => 'item_trx_amt',
    'vname' => 'LBL_ITEM_TRX_AMT',
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
  'item_tax_amt' => 
  array (
    'required' => true,
    'name' => 'item_tax_amt',
    'vname' => 'LBL_ITEM_TAX_AMT',
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
  'item_tax_base' => 
  array (
    'required' => true,
    'name' => 'item_tax_base',
    'vname' => 'LBL_ITEM_TAX_BASE',
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
  'item_line_no' => 
  array (
    'required' => true,
    'name' => 'item_line_no',
    'vname' => 'LBL_ITEM_LINE_NO',
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
  'item_contact_person_2' => 
  array (
    'required' => true,
    'name' => 'item_contact_person_2',
    'vname' => 'LBL_ITEM_CONTACT_PERSON_2',
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
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'full_text_search' => 
    array (
      'enabled' => true,
      'boost' => '1',
      'searchable' => true,
    ),
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'item_incl_excl' => 
  array (
    'required' => false,
    'name' => 'item_incl_excl',
    'vname' => 'LBL_ITEM_INCL_EXCL',
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
  'item_void_flag' => 
  array (
    'required' => false,
    'name' => 'item_void_flag',
    'vname' => 'LBL_ITEM_VOID_FLAG',
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
  'item_scheme_cd' => 
  array (
    'required' => true,
    'name' => 'item_scheme_cd',
    'vname' => 'LBL_ITEM_SCHEME_CD',
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
  'item_gst_tax_reg_no' => 
  array (
    'required' => false,
    'name' => 'item_gst_tax_reg_no',
    'vname' => 'LBL_ITEM_GST_TAX_REG_NO',
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
  'item_tax_cd' => 
  array (
    'required' => true,
    'name' => 'item_tax_cd',
    'vname' => 'LBL_ITEM_TAX_CD',
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
  'item_days' => 
  array (
    'required' => false,
    'name' => 'item_days',
    'vname' => 'LBL_ITEM_DAYS',
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
  'item_mtax_amt' => 
  array (
    'required' => true,
    'name' => 'item_mtax_amt',
    'vname' => 'LBL_ITEM_MTAX_AMT',
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
  'item_tax_ind' => 
  array (
    'required' => false,
    'name' => 'item_tax_ind',
    'vname' => 'LBL_ITEM_TAX_IND',
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
  'item_mbase_amt' => 
  array (
    'required' => true,
    'name' => 'item_mbase_amt',
    'vname' => 'LBL_ITEM_MBASE_AMT',
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
  'item_doc_date' => 
  array (
    'required' => true,
    'name' => 'item_doc_date',
    'vname' => 'LBL_ITEM_DOC_DATE',
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
  'item_credit_terms' => 
  array (
    'required' => false,
    'name' => 'item_credit_terms',
    'vname' => 'LBL_ITEM_CREDIT_TERMS',
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
  'item_currency_rate' => 
  array (
    'required' => false,
    'name' => 'item_currency_rate',
    'vname' => 'LBL_ITEM_CURRENCY_RATE',
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
  'item_audit_date' => 
  array (
    'required' => true,
    'name' => 'item_audit_date',
    'vname' => 'LBL_ITEM_AUDIT_DATE',
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
  'item_due_date' => 
  array (
    'required' => true,
    'name' => 'item_due_date',
    'vname' => 'LBL_ITEM_DUE_DATE',
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
  'item_trx_date' => 
  array (
    'required' => false,
    'name' => 'item_trx_date',
    'vname' => 'LBL_ITEM_TRX_DATE',
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
  'item_tax_rate' => 
  array (
    'required' => true,
    'name' => 'item_tax_rate',
    'vname' => 'LBL_ITEM_TAX_RATE',
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
VardefManager::createVardef('z_invoice_item_new','z_invoice_item_new', array('basic','team_security','assignable','taggable'));