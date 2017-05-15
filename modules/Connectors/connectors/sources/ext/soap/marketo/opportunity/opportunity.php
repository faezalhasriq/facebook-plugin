<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once('modules/Connectors/connectors/sources/ext/soap/marketo/marketo.php');

class ext_soap_marketo_opportunity extends ext_soap_marketo
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

    public function getSchema($object_name = self::OPPORTUNITY)
    {
        return parent::getSchema($object_name);
    }

    /**
     *
     *
     * @param Opportunity $bean
     */
    function deleteOpportunity(Opportunity $bean)
    {
        if (!isset($bean->mrkto2_id_c) && empty($bean->mrkto2_id_c)) {
            return;
        }

        $params = new ParamsGetMObjects(self::OPPORTUNITY);
        $params->id = $bean->mrkto2_id_c;

        // get the opportunity from marketo
        $success = $this->getMObjects($params);
        if ($success !== false) {
            if (!empty($success->result)) {

                if ($success->result->returnCount > 0) {

                    // loop through all of the opportunities that were return
                    foreach ($success->result->mObjectList as $mObject) {

                        $paramsDeleteMObjects = new paramsDeleteMObjects();

                        // find all of the OpportunityPersonRole objects associated with the opportunity,
                        // remove them as well otherwise they will be orphaned

                        $children = $this->getRelatedPeople($mObject->id);
                        if (!empty($children) && $children->result->returnCount > 0) {
                            foreach ($children->result->mObjectList as $child) {
                                $delete = new MObject();
                                $delete->type = $child->type;
                                $delete->id = $child->id;
                                $paramsDeleteMObjects->mObjectList->mObject[] = $delete;
                            }
                        }

                        $paramsDeleteMObjects->mObjectList->mObject[] = $mObject;

                        return $this->deleteMObjects($paramsDeleteMObjects);
                    }
                }
            }
        }
    }


    /**
     *
     * @param $id
     * @return bool|mixed
     */
    function getRelatedPeople($id)
    {
        $params = new ParamsGetMObjects(self::OPPORTUNITY_PERSON_ROLE);

        $info = new MObjAssociation();
        $info->mObjType = self::OPPORTUNITY;
        $info->id = $id;

        $params->mObjAssociationList->mObjAssociation[] = $info;

        return $this->getMObjects($params);
    }

    public function getMapping()
    {
        $mapping = parent::getMapping();
        unset($mapping['beans']['Contacts']);
        unset($mapping['beans']['Leads']);
        $mapping['beans']['Opportunities']['id'] = "mkto_id";

        return $mapping;
    }

    /**
     * Override the source::loadConfig and handle Sugar 6 vs Sugar 7
     */
    public function loadConfig()
    {
        global $sugar_version;
        $config = array();
        $dir = str_replace('_', '/', 'ext_soap_marketo');
        if (version_compare($sugar_version, '7.1.5') < 0) {
            require(get_custom_file_if_exists("modules/Connectors/connectors/sources/{$dir}/config.php"));
        } else {
            foreach (SugarAutoLoader::existingCustom(
                         "modules/Connectors/connectors/sources/{$dir}/config.php"
                     ) as $file) {
                require $file;
            }
            $this->_config = $config;

            //If there are no required config fields specified, we will default them to all be required
            if (empty($this->_required_config_fields)) {
                foreach ($this->_config['properties'] as $id => $value) {
                    $this->_required_config_fields[] = $id;
                }
            }
        }
    }
}
