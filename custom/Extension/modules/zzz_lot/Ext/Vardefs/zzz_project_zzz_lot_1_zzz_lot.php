<?php
// created: 2016-08-24 08:23:32
$dictionary["zzz_lot"]["fields"]["zzz_project_zzz_lot_1"] = array (
  'name' => 'zzz_project_zzz_lot_1',
  'type' => 'link',
  'relationship' => 'zzz_project_zzz_lot_1',
  'source' => 'non-db',
  'module' => 'zzz_project',
  'bean_name' => 'zzz_project',
  'side' => 'right',
  'vname' => 'LBL_ZZZ_PROJECT_ZZZ_LOT_1_FROM_ZZZ_LOT_TITLE',
  'id_name' => 'zzz_project_zzz_lot_1zzz_project_ida',
  'link-type' => 'one',
);
$dictionary["zzz_lot"]["fields"]["zzz_project_zzz_lot_1_name"] = array (
  'name' => 'zzz_project_zzz_lot_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ZZZ_PROJECT_ZZZ_LOT_1_FROM_ZZZ_PROJECT_TITLE',
  'save' => true,
  'id_name' => 'zzz_project_zzz_lot_1zzz_project_ida',
  'link' => 'zzz_project_zzz_lot_1',
  'table' => 'zzz_project',
  'module' => 'zzz_project',
  'rname' => 'name',
);
$dictionary["zzz_lot"]["fields"]["zzz_project_zzz_lot_1zzz_project_ida"] = array (
  'name' => 'zzz_project_zzz_lot_1zzz_project_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ZZZ_PROJECT_ZZZ_LOT_1_FROM_ZZZ_LOT_TITLE_ID',
  'id_name' => 'zzz_project_zzz_lot_1zzz_project_ida',
  'link' => 'zzz_project_zzz_lot_1',
  'table' => 'zzz_project',
  'module' => 'zzz_project',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
