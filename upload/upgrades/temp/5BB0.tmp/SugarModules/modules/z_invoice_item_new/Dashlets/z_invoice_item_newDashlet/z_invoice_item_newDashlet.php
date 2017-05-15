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
/*********************************************************************************
 * $Id$
 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/z_invoice_item_new/z_invoice_item_new.php');

class z_invoice_item_newDashlet extends DashletGeneric { 
    function z_invoice_item_newDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/z_invoice_item_new/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'z_invoice_item_new');

        $this->searchFields = $dashletData['z_invoice_item_newDashlet']['searchFields'];
        $this->columns = $dashletData['z_invoice_item_newDashlet']['columns'];

        $this->seedBean = new z_invoice_item_new();        
    }
}