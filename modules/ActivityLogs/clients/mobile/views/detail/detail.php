<?php
/*
 * Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
 * pursuant to the terms of the End User License Agreement available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
 */

$module_name = 'ActivityLogs';
$viewdefs[$module_name] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'detail' => 
      array (
        'templateMeta' => 
        array (
          'form' => 
          array (
            'buttons' => 
            array (
              0 => 'EDIT',
              1 => 'DUPLICATE',
              2 => 'DELETE',
            ),
          ),
          'maxColumns' => '1',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
            1 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
          ),
          'useTabs' => false,
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 'name',
              1 => 
              array (
                'name' => 'campaign_name',
                'label' => 'LBL_CAMPAIGN_NAME',
              ),
              2 => 
              array (
                'name' => 'date_modified',
                'comment' => 'Date record last modified',
                'studio' => 
                array (
                  'portaleditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_DATE_MODIFIED',
              ),
              3 => 
              array (
                'name' => 'mkto_id',
                'label' => 'LBL_MKTO_ID',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
