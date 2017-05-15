<?php

$admin_option_defs = array();
$admin_option_defs['Administration']['facebook_dashlet_config'] = array(
    'Administration',
    'LBL_FACEBOOK_DASHLET_SETTINGS_LINK_NAME',
    'LBL_FACEBOOK_DASHLET_SETTINGS_LINK_DESCRIPTION',
    'javascript:parent.SUGAR.App.router.navigate("Cases/layout/facebook-dashlet-config", {trigger: true});',
);

$admin_group_header[] = array(
    'LBL_FACEBOOK_DASHLET_SETTINGS_SECTION_HEADER',
    '',
    false,
    $admin_option_defs,
    'LBL_FACEBOOK_DASHLET_SETTINGS_SECTION_DESCRIPTION',
);
