<?php
$module_name = 'z__payments';
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
                'name' => 'payment_id',
                'label' => 'LBL_PAYMENT_ID',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'payment_date',
                'label' => 'LBL_PAYMENT_DATE',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'payment_amt',
                'label' => 'LBL_PAYMENT_AMT',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'payment_status',
                'label' => 'LBL_PAYMENT_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              6 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              9 => 
              array (
                'name' => 'payment_from',
                'label' => 'LBL_PAYMENT_FROM',
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
