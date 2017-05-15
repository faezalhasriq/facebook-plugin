<?php
$module_name = 'zzz_lot';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
            'events' => 
            array (
              'click' => 'button:cancel_button:click',
            ),
          ),
          1 => 
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:edit_button:click',
                'name' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'shareaction',
                'name' => 'share',
                'label' => 'LBL_RECORD_SHARE_BUTTON',
                'acl_action' => 'view',
              ),
              2 => 
              array (
                'type' => 'pdfaction',
                'name' => 'download-pdf',
                'label' => 'LBL_PDF_VIEW',
                'action' => 'download',
                'acl_action' => 'view',
              ),
              3 => 
              array (
                'type' => 'pdfaction',
                'name' => 'email-pdf',
                'label' => 'LBL_PDF_EMAIL',
                'action' => 'email',
                'acl_action' => 'view',
              ),
              4 => 
              array (
                'type' => 'divider',
              ),
              5 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              6 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'zzz_lot',
                'acl_action' => 'create',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              8 => 
              array (
                'type' => 'divider',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
            ),
          ),
          3 => 
          array (
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
          ),
        ),
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'label' => 'LBL_RECORD_HEADER',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'width' => 42,
                'height' => 42,
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 'name',
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              3 => 
              array (
                'name' => 'follow',
                'label' => 'LBL_FOLLOW',
                'type' => 'follow',
                'readonly' => true,
                'dismiss_label' => true,
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'lot_code',
                'label' => 'LBL_LOT_CODE',
              ),
              1 => 
              array (
                'name' => 'lot_handover_date',
                'label' => 'LBL_LOT_HANDOVER_DATE',
              ),
              2 => 
              array (
                'name' => 'lot_status',
                'label' => 'LBL_LOT_STATUS',
                'span' => 12,
              ),
              3 => 
              array (
                'name' => 'lot_bumi_lot',
                'label' => 'LBL_LOT_BUMI_LOT',
              ),
              4 => 
              array (
                'name' => 'lot_bumi_release',
                'label' => 'LBL_LOT_BUMI_RELEASE',
              ),
              5 => 
              array (
              ),
              6 => 
              array (
                'name' => 'lot_address_street',
                'label' => 'LBL_LOT_ADDRESS_STREET',
              ),
              7 => 
              array (
              ),
              8 => 
              array (
                'name' => 'lot_address_city',
                'label' => 'LBL_LOT_ADDRESS_CITY',
              ),
              9 => 
              array (
              ),
              10 => 
              array (
                'name' => 'lot_address_postalcode',
                'label' => 'LBL_LOT_ADDRESS_POSTALCODE',
              ),
              11 => 
              array (
              ),
              12 => 
              array (
                'name' => 'lot_address_state',
                'label' => 'LBL_LOT_ADDRESS_STATE',
              ),
              13 => 
              array (
                'name' => 'lot_management_reserve',
                'label' => 'LBL_LOT_MANAGEMENT_RESERVE',
                'span' => 12,
              ),
              14 => 
              array (
                'name' => 'lot_booking_date',
                'label' => 'LBL_LOT_BOOKING_DATE',
              ),
              15 => 
              array (
                'name' => 'lot_booking_remark',
                'label' => 'LBL_LOT_BOOKING_REMARK',
              ),
              16 => 'assigned_user_name',
              17 => 'team_name',
              18 => 
              array (
                'name' => 'date_entered',
                'comment' => 'Date record created',
                'studio' => 
                array (
                  'portaleditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_DATE_ENTERED',
              ),
              19 => 
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
            ),
          ),
          2 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_SHOW_MORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'lot_hsd_no',
                'label' => 'LBL_LOT_HSD_NO',
              ),
              1 => 
              array (
                'name' => 'lot_ptd_no',
                'label' => 'LBL_LOT_PTD_NO',
              ),
              2 => 
              array (
                'name' => 'lot_unit_measure',
                'label' => 'LBL_LOT_UNIT_MEASURE',
              ),
              3 => 
              array (
                'name' => 'lot_buildup_area',
                'label' => 'LBL_LOT_BUILDUP_AREA',
              ),
              4 => 
              array (
                'name' => 'lot_land_area',
                'label' => 'LBL_LOT_LAND_AREA',
                'span' => 12,
              ),
              5 => 
              array (
                'name' => 'lot_position',
                'label' => 'LBL_LOT_POSITION',
              ),
              6 => 
              array (
                'name' => 'lot_direction',
                'label' => 'LBL_LOT_DIRECTION',
              ),
              7 => 
              array (
                'name' => 'lot_building_type',
                'label' => 'LBL_LOT_BUILDING_TYPE',
              ),
              8 => 
              array (
                'name' => 'lot_building_design',
                'label' => 'LBL_LOT_BUILDING_DESIGN',
              ),
              9 => 
              array (
                'name' => 'lot_block',
                'label' => 'LBL_LOT_BLOCK',
              ),
              10 => 
              array (
                'name' => 'lot_level',
                'label' => 'LBL_LOT_LEVEL',
              ),
              11 => 
              array (
                'name' => 'lot_view_type',
                'label' => 'LBL_LOT_VIEW_TYPE',
              ),
              12 => 
              array (
                'name' => 'lot_finishing',
                'label' => 'LBL_LOT_FINISHING',
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'lot_list_price',
                'label' => 'LBL_LOT_LIST_PRICE',
              ),
              1 => 
              array (
                'name' => 'lot_total_amt',
                'label' => 'LBL_LOT_TOTAL_AMT',
              ),
              2 => 
              array (
                'name' => 'lot_est_selling_prc',
                'label' => 'LBL_LOT_EST_SELLING_PRC',
              ),
              3 => 
              array (
                'name' => 'lot_tax_exclude',
                'label' => 'LBL_LOT_TAX_EXCLUDE',
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => true,
        ),
      ),
    ),
  ),
);
