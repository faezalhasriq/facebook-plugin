<?php
// created: 2016-08-22 09:03:56
$dictionary["z_invoice_z_item"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'z_invoice_z_item' => 
    array (
      'lhs_module' => 'z_invoice',
      'lhs_table' => 'z_invoice',
      'lhs_key' => 'id',
      'rhs_module' => 'z_item',
      'rhs_table' => 'z_item',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'z_invoice_z_item_c',
      'join_key_lhs' => 'z_invoice_z_itemz_invoice_ida',
      'join_key_rhs' => 'z_invoice_z_itemz_item_idb',
    ),
  ),
  'table' => 'z_invoice_z_item_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'z_invoice_z_itemz_invoice_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'z_invoice_z_itemz_item_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'z_invoice_z_itemspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'z_invoice_z_item_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'z_invoice_z_itemz_invoice_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'z_invoice_z_item_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'z_invoice_z_itemz_item_idb',
      ),
    ),
  ),
);