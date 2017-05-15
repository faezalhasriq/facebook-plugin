<?php
// created: 2016-08-24 08:23:32
$dictionary["zzz_project_zzz_lot_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'zzz_project_zzz_lot_1' => 
    array (
      'lhs_module' => 'zzz_project',
      'lhs_table' => 'zzz_project',
      'lhs_key' => 'id',
      'rhs_module' => 'zzz_lot',
      'rhs_table' => 'zzz_lot',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'zzz_project_zzz_lot_1_c',
      'join_key_lhs' => 'zzz_project_zzz_lot_1zzz_project_ida',
      'join_key_rhs' => 'zzz_project_zzz_lot_1zzz_lot_idb',
    ),
  ),
  'table' => 'zzz_project_zzz_lot_1_c',
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
      'name' => 'zzz_project_zzz_lot_1zzz_project_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'zzz_project_zzz_lot_1zzz_lot_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'zzz_project_zzz_lot_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'zzz_project_zzz_lot_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'zzz_project_zzz_lot_1zzz_project_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'zzz_project_zzz_lot_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'zzz_project_zzz_lot_1zzz_lot_idb',
      ),
    ),
  ),
);