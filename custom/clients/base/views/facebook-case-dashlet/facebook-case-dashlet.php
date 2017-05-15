<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$viewdefs['base']['view']['facebook-case-dashlet'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_DASHLET_FACEBOOK_CASES_NAME',
            'description' => 'LBL_DASHLET_FACEBOOK_CASES_DESCRIPTION',
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
);
