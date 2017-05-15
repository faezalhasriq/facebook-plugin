<?php
// created: 2016-08-23 07:53:20
$dictionary["z_invoice_item"]["fields"]["z_invoice_z_invoice_item_1"] = array (
  'name' => 'z_invoice_z_invoice_item_1',
  'type' => 'link',
  'relationship' => 'z_invoice_z_invoice_item_1',
  'source' => 'non-db',
  'module' => 'z_invoice',
  'bean_name' => 'z_invoice',
  'side' => 'right',
  'vname' => 'LBL_Z_INVOICE_Z_INVOICE_ITEM_1_FROM_Z_INVOICE_ITEM_TITLE',
  'id_name' => 'z_invoice_z_invoice_item_1z_invoice_ida',
  'link-type' => 'one',
);
$dictionary["z_invoice_item"]["fields"]["z_invoice_z_invoice_item_1_name"] = array (
  'name' => 'z_invoice_z_invoice_item_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_Z_INVOICE_Z_INVOICE_ITEM_1_FROM_Z_INVOICE_TITLE',
  'save' => true,
  'id_name' => 'z_invoice_z_invoice_item_1z_invoice_ida',
  'link' => 'z_invoice_z_invoice_item_1',
  'table' => 'z_invoice',
  'module' => 'z_invoice',
  'rname' => 'name',
);
$dictionary["z_invoice_item"]["fields"]["z_invoice_z_invoice_item_1z_invoice_ida"] = array (
  'name' => 'z_invoice_z_invoice_item_1z_invoice_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_Z_INVOICE_Z_INVOICE_ITEM_1_FROM_Z_INVOICE_ITEM_TITLE_ID',
  'id_name' => 'z_invoice_z_invoice_item_1z_invoice_ida',
  'link' => 'z_invoice_z_invoice_item_1',
  'table' => 'z_invoice',
  'module' => 'z_invoice',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
