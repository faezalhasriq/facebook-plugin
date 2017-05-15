<?php
 // created: 2016-08-22 09:03:56
$layout_defs["z_invoice"]["subpanel_setup"]['z_invoice_z_item'] = array (
  'order' => 100,
  'module' => 'z_item',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_Z_INVOICE_Z_ITEM_FROM_Z_ITEM_TITLE',
  'get_subpanel_data' => 'z_invoice_z_item',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
