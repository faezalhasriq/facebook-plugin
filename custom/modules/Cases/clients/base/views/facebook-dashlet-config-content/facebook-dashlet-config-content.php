<?php
$viewdefs['Cases']['base']['view']['facebook-dashlet-config-content'] = array(
    'fields' => array(
        'fb_license_type' => array(
            'name' => 'fb_license_type',
            'type' => 'enum',
            'options' => 'license_type_list',
            'label' => 'LBL_LICENSE_TYPE',
            'default' => 'addoptify',
            'span' => 6
        ),
        'fb_page_name' => array(
            'name' => 'fb_page_name',
            'type' => 'varchar',
            'label' => 'LBL_FACEBOOK_DASHLET_CONFIG_DEFAULT_PAGE_NAME',
            'default' => '',
            'span' => 6,
            'description' => 'LBL_FACEBOOK_DASHLET_CONFIG_DEFAULT_PAGE_NAME_DESCRIPTION',
        ),
        'fb_app_id' => array(
            'name' => 'fb_app_id',
            'type' => 'varchar',
            'label' => 'LBL_FACEBOOK_DASHLET_CONFIG_APP_ID',
            'default' => '',
            'span' => 6,
            'description' => 'LBL_FACEBOOK_DASHLET_CONFIG_APP_ID_DESCRIPTION',
        ),
        'fb_log_level' => array(
            'name' => 'fb_log_level',
            'type' => 'enum',
            'options' => 'log_level_list',
            'label' => 'LBL_FACEBOOK_DASHLET_CONFIG_LOG_LEVEL',
            'default' => 'debug',
            'span' => 6,
            'description' => 'LBL_FACEBOOK_DASHLET_CONFIG_LOG_LEVEL_DESCRIPTION',
        ),
    ),
    'addoptify_fields' => array(
        array(
            'name' => 'fb_license_key',
            'label' => 'LBL_FACEBOOK_DASHLET_CONFIG_LICENSE_KEY',
        ),
        array(
            'name' => 'fb_validation_key',
            'label' => 'LBL_FACEBOOK_DASHLET_CONFIG_VALIDATION_KEY',
            'description' => 'LBL_FACEBOOK_DASHLET_CONFIG_VALIDATION_KEY_DESCRIPTION',
        ),
    ),
    'outfitters_fields' => array(
        array(
            'name' => 'fb_license_key',
            'label' => 'LBL_FACEBOOK_DASHLET_CONFIG_LICENSE_KEY',
        ),
    ),
);
