<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('modules/Connectors/connectors/sources/ext/soap/marketo/opportunity/opportunity.php');

class ext_soap_marketo_role extends ext_soap_marketo_opportunity
{

    public function __construct()
    {
        global $app_list_strings;

        parent::__construct();

        $this->allowedModuleList = array(
            'Opportunities' => $app_list_strings['moduleList']['Opportunities'],
        );
        $this->_has_testing_enabled = false;
        $this->_enable_in_wizard = false;
    }

    public function getSchema($object_name = self::OPPORTUNITY_PERSON_ROLE)
    {
        return parent::getSchema($object_name);
    }
}

