<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*
 * Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
 * pursuant to the terms of the End User License Agreement available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
 */

require_once('include/MVC/View/views/view.list.php');

class ViewSourceProperties extends ViewList
{

    function ViewSourceProperties()
    {
        parent::ViewList();
    }

    function display()
    {
        require_once('include/connectors/sources/SourceFactory.php');
        require_once('include/connectors/utils/ConnectorUtils.php');

        $source_id = $_REQUEST['source_id'];
        $connector_language = ConnectorUtils::getConnectorStrings($source_id);
        $source = SourceFactory::getSource($source_id);
        $properties = $source->getProperties();

        $required_fields = array();
        $config_fields = $source->getRequiredConfigFields();
        $fields = $source->getRequiredConfigFields();
        foreach ($fields as $field_id) {
            $label = isset($connector_language[$field_id]) ? $connector_language[$field_id] : $field_id;
            $required_fields[$field_id] = $label;
        }

        $this->ss->assign('required_properties', $required_fields);
        $this->ss->assign('source_id', $source_id);
        $this->ss->assign('properties', $properties);
        $this->ss->assign('mod', $GLOBALS['mod_strings']);
        $this->ss->assign('app', $GLOBALS['app_strings']);
        $this->ss->assign('connector_language', $connector_language);
        $this->ss->assign('hasTestingEnabled', $source->hasTestingEnabled());

        $dir = str_replace('_', '/', $source_id);

        if ($this->getCustomFilePathIfExists("modules/Connectors/connectors/sources/{$dir}/views/sourceproperties.php") != null) {
            require_once($this->getCustomFilePathIfExists("modules/Connectors/connectors/sources/{$dir}/views/sourceproperties.php"));
        }

        if ($this->getCustomFilePathIfExists("modules/Connectors/connectors/sources/{$dir}/tpls/source_properties.tpl") != null)
            echo $this->ss->fetch($this->getCustomFilePathIfExists("modules/Connectors/connectors/sources/{$dir}/tpls/source_properties.tpl"));
        else
            echo $this->ss->fetch($this->getCustomFilePathIfExists('modules/Connectors/tpls/source_properties.tpl'));
    }
}

