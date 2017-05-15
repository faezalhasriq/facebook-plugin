<?php
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

// THIS CONTENT IS GENERATED BY MBPackage.php
$manifest = array (
  'built_in_version' => '7.7.0.0',
  'acceptable_sugar_versions' => 
  array (
    0 => '',
  ),
  'acceptable_sugar_flavors' => 
  array (
    0 => 'PRO',
    1 => 'CORP',
    2 => 'ENT',
    3 => 'ULT',
  ),
  'readme' => '',
  'key' => 'z',
  'author' => '',
  'description' => '',
  'icon' => '',
  'is_uninstallable' => true,
  'name' => 'invoice',
  'published_date' => '2016-08-24 04:02:50',
  'type' => 'module',
  'version' => 1472011371,
  'remove_tables' => 'prompt',
);


$installdefs = array (
  'id' => 'invoice',
  'beans' => 
  array (
    0 => 
    array (
      'module' => 'z_invoice',
      'class' => 'z_invoice',
      'path' => 'modules/z_invoice/z_invoice.php',
      'tab' => true,
    ),
    1 => 
    array (
      'module' => 'z_invoice_item',
      'class' => 'z_invoice_item',
      'path' => 'modules/z_invoice_item/z_invoice_item.php',
      'tab' => true,
    ),
    2 => 
    array (
      'module' => 'z_invoice_item_new',
      'class' => 'z_invoice_item_new',
      'path' => 'modules/z_invoice_item_new/z_invoice_item_new.php',
      'tab' => true,
    ),
  ),
  'layoutdefs' => 
  array (
  ),
  'relationships' => 
  array (
  ),
  'image_dir' => '<basepath>/icons',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/modules/z_invoice',
      'to' => 'modules/z_invoice',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/modules/z_invoice_item',
      'to' => 'modules/z_invoice_item',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/modules/z_invoice_item_new',
      'to' => 'modules/z_invoice_item_new',
    ),
  ),
  'language' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
  ),
);