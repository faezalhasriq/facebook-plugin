<?php
$module_name = 'z_invoice_item_new';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'item_doc_no',
                'label' => 'LBL_ITEM_DOC_NO',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'item_descs_3',
                'label' => 'LBL_ITEM_DESCS_3',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'item_descs_4',
                'label' => 'LBL_ITEM_DESCS_4',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'item_trx_amt',
                'label' => 'LBL_ITEM_TRX_AMT',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              8 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
