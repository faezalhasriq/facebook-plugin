<?php
/**
 * Metadata for the Case Count by Status example dashlet view
 * 
 * This dashlet is only allowed to appear on the Case module's list view
 * which is also known as the 'records' layout.
 */
$viewdefs['base']['view']['facebook-plugin-dashlet'] = array(
    'dashlets' => array(
        array(
            //Display label for this dashlet
            'label' => 'LBL_FACEBOOK_PLUGIN_DASHLET_NAME',
            //Description label for this Dashlet
            'description' => 'LBL_FACEBOOK_PLUGIN_DASHLET_NAME_DESCRIPTION',
            'config' => array(
                'limit' => '3',
            ),
            'preview' => array(
                'limit' => '3',
            ),
            'filter' => array(
                'module' => array(
                    'Home',
                    'Cases',
                ),
                'view' => 'record',
            ),
        ),
    ),
	
	'config' => array(
		'fields' => array(
			array(
				'type' => 'rowaction',
				'event' => 'button:fb_logout:click',
				'name' => 'fb_logout',
				'label' => 'Facebook Logout',
				'css_class' => 'btn fa fa-sign-out',
			),
        ),
	),
);