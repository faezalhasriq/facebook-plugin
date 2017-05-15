<?php
$module_name = 'z_invoice';
$subpanel_layout = 
array (
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'z_invoice',
    ),
  ),
  'where' => '',
  'list_fields' => 
  array (
    'invoice_no' => 
    array (
      'type' => 'varchar',
      'default' => true,
      'vname' => 'LBL_INVOICE_NO',
      'width' => '10%',
    ),
    'name' => 
    array (
      'vname' => 'LBL_NAME',
      'widget_class' => 'SubPanelDetailViewLink',
      'width' => '10%',
      'default' => true,
    ),
    'invoice_date' => 
    array (
      'type' => 'date',
      'vname' => 'LBL_INVOICE_DATE',
      'width' => '10%',
      'default' => true,
    ),
    'invoice_debtor_acc' => 
    array (
      'type' => 'varchar',
      'default' => true,
      'vname' => 'LBL_INVOICE_DEBTOR_ACC',
      'width' => '10%',
    ),
    'edit_button' => 
    array (
      'vname' => 'LBL_EDIT_BUTTON',
      'widget_class' => 'SubPanelEditButton',
      'module' => 'z_invoice',
      'width' => '4%',
    ),
    'remove_button' => 
    array (
      'vname' => 'LBL_REMOVE',
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'z_invoice',
      'width' => '5%',
    ),
  ),
);
