<?php
 // created: 2016-08-23 07:53:20
$layout_defs["z_invoice"]["subpanel_setup"]['z_invoice_z_invoice_item_1'] = array (
  'order' => 100,
  'module' => 'z_invoice_item',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_Z_INVOICE_Z_INVOICE_ITEM_1_FROM_Z_INVOICE_ITEM_TITLE',
  'get_subpanel_data' => 'z_invoice_z_invoice_item_1',
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
