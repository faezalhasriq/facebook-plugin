<?php
// created: 2016-08-22 09:03:56
$dictionary["z_item"]["fields"]["z_invoice_z_item"] = array (
  'name' => 'z_invoice_z_item',
  'type' => 'link',
  'relationship' => 'z_invoice_z_item',
  'source' => 'non-db',
  'module' => 'z_invoice',
  'bean_name' => 'z_invoice',
  'side' => 'right',
  'vname' => 'LBL_Z_INVOICE_Z_ITEM_FROM_Z_ITEM_TITLE',
  'id_name' => 'z_invoice_z_itemz_invoice_ida',
  'link-type' => 'one',
);
$dictionary["z_item"]["fields"]["z_invoice_z_item_name"] = array (
  'name' => 'z_invoice_z_item_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_Z_INVOICE_Z_ITEM_FROM_Z_INVOICE_TITLE',
  'save' => true,
  'id_name' => 'z_invoice_z_itemz_invoice_ida',
  'link' => 'z_invoice_z_item',
  'table' => 'z_invoice',
  'module' => 'z_invoice',
  'rname' => 'name',
);
$dictionary["z_item"]["fields"]["z_invoice_z_itemz_invoice_ida"] = array (
  'name' => 'z_invoice_z_itemz_invoice_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_Z_INVOICE_Z_ITEM_FROM_Z_ITEM_TITLE_ID',
  'id_name' => 'z_invoice_z_itemz_invoice_ida',
  'link' => 'z_invoice_z_item',
  'table' => 'z_invoice',
  'module' => 'z_invoice',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
