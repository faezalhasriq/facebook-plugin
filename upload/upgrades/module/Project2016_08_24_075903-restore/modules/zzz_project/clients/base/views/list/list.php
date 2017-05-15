<?php
$module_name = 'zzz_project';
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
                'name' => 'project_code',
                'label' => 'LBL_PROJECT_CODE',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'project_ref',
                'label' => 'LBL_PROJECT_REF',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              4 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              5 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              6 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
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
