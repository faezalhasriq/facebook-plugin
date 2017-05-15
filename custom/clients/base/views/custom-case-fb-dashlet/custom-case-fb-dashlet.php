<?php
/**
 * Metadata for the Case Count by Status example dashlet view
 * 
 * This dashlet is only allowed to appear on the Case module's list view
 * which is also known as the 'records' layout.
 */
$viewdefs['base']['view']['custom-case-fb-dashlet'] = array(
    'dashlets' => array(
        array(
            //Display label for this dashlet
            'label' => 'Custom Case-Facebook Post Dashlet',
            //Description label for this Dashlet
            'description' => 'A custom deshlet to retrieve fb post for case module',
            'config' => array(
                'limit' => '3',
            ),
            'preview' => array(
                'limit' => '3',
            ),
            'filter' => array(
                'module' => array(
                    'Cases',
                ),
                'view' => 'record',
            ),
        ),
    ),
	
	'config' => array(
        'fields' => array(
            array(
                'name' => 'hide_has_cases',
                'label' => 'LBL_DASHLET_FACEBOOK_CONFIG_HAS_CASES',
                'type' => 'bool',
                'searchBarThreshold' => -1,
            ),
            array(
                'name' => 'page_name',
                'label' => 'LBL_DASHLET_FACEBOOK_CONFIG_PAGE_NAME_OVERRIDE',
                'type' => 'varchar',
                'searchBarThreshold' => -1,
            ),
        ),
    ),
	
	'dashlet_config_panels' =>
        array(
            array(
                'name' => 'panel_body',
                'columns' => 2,
                'labelsOnTop' => true,
                'placeholders' => true,
                'fields' => array(
                    array(
                        'name' => 'auto_refresh',
                        'label' => 'LBL_REPORT_AUTO_REFRESH',
                        'type' => 'enum',
                        'options' => 'sugar7_dashlet_auto_refresh_options'
                    ),
                ),
            ),
        ),
);