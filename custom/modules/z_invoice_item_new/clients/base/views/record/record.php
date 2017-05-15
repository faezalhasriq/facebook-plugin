<?php
$module_name = 'z_invoice_item_new';
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
                'acl_module' => 'z_invoice_item_new',
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
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 'assigned_user_name',
              1 => 'team_name',
              2 => 
              array (
                'name' => 'item_entity_cd',
                'label' => 'LBL_ITEM_ENTITY_CD',
              ),
              3 => 
              array (
                'name' => 'item_project_no',
                'label' => 'LBL_ITEM_PROJECT_NO',
              ),
              4 => 
              array (
                'name' => 'item_mbase_amt',
                'label' => 'LBL_ITEM_MBASE_AMT',
              ),
              5 => 
              array (
                'name' => 'item_mtax_amt',
                'label' => 'LBL_ITEM_MTAX_AMT',
              ),
              6 => 
              array (
                'name' => 'item_doc_no',
                'label' => 'LBL_ITEM_DOC_NO',
              ),
              7 => 
              array (
                'name' => 'item_doc_date',
                'label' => 'LBL_ITEM_DOC_DATE',
              ),
              8 => 
              array (
                'name' => 'item_fbase_amt',
                'label' => 'LBL_ITEM_FBASE_AMT',
              ),
              9 => 
              array (
                'name' => 'item_ftax_amt',
                'label' => 'LBL_ITEM_FTAX_AMT',
              ),
              10 => 
              array (
                'name' => 'item_fdoc_amt',
                'label' => 'LBL_ITEM_FDOC_AMT',
              ),
              11 => 
              array (
                'name' => 'item_due_date',
                'label' => 'LBL_ITEM_DUE_DATE',
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
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'date_modified_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_MODIFIED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_modified',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'modified_by_name',
                  ),
                ),
              ),
              1 => 
              array (
                'name' => 'date_entered_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_ENTERED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_entered',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'created_by_name',
                  ),
                ),
              ),
              2 => 
              array (
                'name' => 'item_gst_tax_reg_no',
                'label' => 'LBL_ITEM_GST_TAX_REG_NO',
              ),
              3 => 
              array (
                'name' => 'item_giro_acctno',
                'label' => 'LBL_ITEM_GIRO_ACCTNO',
              ),
              4 => 
              array (
                'name' => 'item_trx_amt',
                'label' => 'LBL_ITEM_TRX_AMT',
              ),
              5 => 
              array (
                'name' => 'item_contact_person_2',
                'label' => 'LBL_ITEM_CONTACT_PERSON_2',
              ),
              6 => 
              array (
                'name' => 'item_trx_date',
                'label' => 'LBL_ITEM_TRX_DATE',
              ),
              7 => 
              array (
                'name' => 'item_debtor_acct',
                'label' => 'LBL_ITEM_DEBTOR_ACCT',
              ),
              8 => 
              array (
                'name' => 'item_descs_1',
                'label' => 'LBL_ITEM_DESCS_1',
              ),
              9 => 
              array (
                'name' => 'item_descs_2',
                'label' => 'LBL_ITEM_DESCS_2',
              ),
              10 => 
              array (
                'name' => 'item_descs_3',
                'label' => 'LBL_ITEM_DESCS_3',
              ),
              11 => 
              array (
                'name' => 'item_descs_4',
                'label' => 'LBL_ITEM_DESCS_4',
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => false,
        ),
      ),
    ),
  ),
);
