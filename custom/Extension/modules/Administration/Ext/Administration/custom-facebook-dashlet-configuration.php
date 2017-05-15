<?php

$admin_option_defs = array();
$admin_option_defs['Administration']['custom-facebook-dashlet-configuration'] = array(
    //Icon name. Available icons are located in ./themes/default/images
	'Administration',
    
	//Link name label 
	'LBL_CUSTOM_FACEBOOK_DASHLET_SETTINGS_LINK_NAME',
    
	//Link description label
	'LBL_CUSTOM_FACEBOOK_DASHLET_SETTINGS_LINK_DESCRIPTION',
    
	//Link URL - For Sidecar modules
	'javascript:parent.SUGAR.App.router.navigate("Cases/layout/custom-facebook-dashlet-config", {trigger: true});',
	
	//Alternatively, if you are linking to BWC modules
	//'./index.php?module=<module>&action=<action>',
);

$admin_group_header[] = array(
    //Section header label
	'LBL_CUSTOM_FACEBOOK_DASHLET_SETTINGS_SECTION_HEADER',
    
	//$other_text parameter for get_form_header()
	'',
    
	//$show_help parameter for get_form_header()
	false,
    
	//Section links
	$admin_option_defs,
    
	//Section description label
	'LBL_CUSTOM_FACEBOOK_DASHLET_SETTINGS_SECTION_DESCRIPTION',
);
