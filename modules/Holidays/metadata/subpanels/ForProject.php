<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

// $Id: default.php 13782 2006-06-06 17:58:55 +0000 (Tue, 06 Jun 2006) majed $
$subpanel_layout = array(
	'top_buttons' => array(
			array('widget_class' => 'SubPanelTopCreateButton'),
	),

	'where' => '',

	'list_fields' => array(
		'resource_name'=>array(
			'vname' => 'LBL_RESOURCE_NAME',
			'width' => '30%',
		),		
        'holiday_date'=>array(
		 	'vname' => 'LBL_HOLIDAY_DATE',
			'width' => '20%',
		),
		'description'=>array(
		 	'vname' => 'LBL_DESCRIPTION',
			'width' => '48%',
			'sortable'=>false,			
		),
		'remove_button'=>array(
			 'widget_class' => 'SubPanelRemoveButtonProjects',
			 'width' => '2%',
		),	
		'first_name' => array(
		    'usage'=>'query_only',
		),
		'last_name' => array(
		    'usage'=>'query_only',
		)		
	),
);
?>