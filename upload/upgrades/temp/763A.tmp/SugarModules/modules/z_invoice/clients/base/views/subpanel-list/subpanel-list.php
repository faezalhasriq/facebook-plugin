<?php
// created: 2016-08-22 08:33:40
$viewdefs['z_invoice']['base']['view']['subpanel-list'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'invoice_date',
          'label' => 'LBL_INVOICE_DATE',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'invoice_debtor_acc',
          'label' => 'LBL_INVOICE_DEBTOR_ACC',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'orderBy' => 
  array (
    'field' => 'date_modified',
    'direction' => 'desc',
  ),
);