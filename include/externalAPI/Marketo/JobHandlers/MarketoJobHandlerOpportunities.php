<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

class MarketoJobHandlerOpportunities extends MarketoJobHandlerBase {

    protected $rows_per_loop = 1;

    protected $loops = 100;

    protected $targetModule = 'Opportunities';
    /**
     * @inheritdoc
     */
    protected function getRows() {
        $fetchedRows = array();
        $sql = "select * from {$this->table_name} where deleted = 0 AND bean_module in ('{$this->targetModule}') ORDER BY date_entered ASC";

        $results = $this->db->limitQuery($sql, 0, $this->rows_per_loop);

        while ($row = $this->db->fetchRow($results)) {
            $fetchedRows[] = $row;
        }
        return $fetchedRows;
    }
    /**
     * @inheritdoc
     */
    protected function handleRows($rows) {
        if (!(count($rows)> 0)) {
            return;
        }

        $row =$rows[0] ;
        $data = $row['data'];

        global $app_list_strings;
        if (MarketoFactory::getInstance(false, MarketoFactory::OPPORTUNITY)->isEnabled()) {
            $this->markRowComplete($row['id']);
            $data = unserialize(base64_decode($data));
            try {
                $mkto = MarketoFactory::getInstance(true, MarketoFactory::OPPORTUNITY);

                switch ($data['action']) {
                    case 'DELETE':
                        $paramsDeleteMObjects = new ParamsDeleteMObjects();
                        if (!empty($data['opportunity'])) {
                            $paramsDeleteMObjects->add($data['opportunity']);
                        }
                        if (!empty($data['contacts'])) {
                            if (!is_array($data['contacts'])) {
                                $data['contacts'] = array($data['contacts']);
                            }

                            foreach ($data['contacts'] as $contact) {
                                $paramsDeleteMObjects->add($contact);
                            }
                        }

                        $objects = $paramsDeleteMObjects->getMObjectList();
                        if (!empty($objects)) {
                            $successDeleteMObjects = $mkto->deleteMObjects($paramsDeleteMObjects);
                        }

                        break;

                    case 'UPSERT':

                        if (!empty($data['opportunity'])) {

                            $paramsSyncMObjects = new ParamsSyncMObjects();
                            $paramsSyncMObjects->add($data['opportunity']);
                            $successSyncMObjects = $mkto->syncMObjects($paramsSyncMObjects);

                            if (!is_array($successSyncMObjects->result->mObjStatusList->mObjStatus)) {
                                $successSyncMObjects->result->mObjStatusList->mObjStatus = array($successSyncMObjects->result->mObjStatusList->mObjStatus);
                            }

                            foreach ($successSyncMObjects->result->mObjStatusList->mObjStatus as $mObjStatus) {

                                $opp = BeanFactory::getBean('Opportunities', $mObjStatus->externalKey->getAttrValue());

                                if (!empty($opp->id)) {
                                    $opp->load_relationship('contacts');

                                    if ($mObjStatus->status == MObjStatusEnum::CREATED) {
                                        $opp->mkto_id = $mObjStatus->id;
                                        $opp->in_workflow = true;
                                        $opp->update_date_modified = false;
                                        $opp->update_modified_by = false;
                                        $opp->logicHookDepth['before_save'] = 1000;
                                        $opp->logicHookDepth['after_relationship_add'] = 1000;
                                        $opp->save();
                                    }

                                    $syncContacts = new ParamsSyncMObjects();

                                    foreach ($opp->contacts->getBeans() as $contact) {
                                        if (!empty($contact->mkto_id)) {

                                            $opportunityPersonRole = new MObject();
                                            $opportunityPersonRole->setId($contact->opportunity_role_mkto_id);
                                            $opportunityPersonRole->setType($mkto::OPPORTUNITY_PERSON_ROLE);

                                            $externalKey = new Attribute();
                                            $externalKey->attrName = "contacts.id";
                                            $externalKey->attrValue = $contact->id;
                                            $opportunityPersonRole->setExternalKey($externalKey);

                                            $arrayOfAttrib = new ArrayOfAttrib();
                                            $arrayOfAttrib->add(new Attrib('PersonId', $contact->mkto_id));
                                            $arrayOfAttrib->add(new Attrib('OpportunityId', $opp->mkto_id));
                                            $arrayOfAttrib->add(
                                                new Attrib('Role', $app_list_strings['opportunity_relationship_type_dom'][empty($contact->opportunity_role) ? 'Other' : $contact->opportunity_role])
                                            );
                                            $arrayOfAttrib->add(
                                                new Attrib('IsPrimary', (strpos(
                                                        $contact->opportunity_role,
                                                        'Primary'
                                                    ) === 0) ? 'true' : 'false')
                                            );
                                            $opportunityPersonRole->setAttribList($arrayOfAttrib);
                                            $syncContacts->add($opportunityPersonRole);
                                        }
                                    }

                                    $this->syncContacts($mkto, $syncContacts, $opp);
                                }
                            }
                        } else {
                            if (!empty($data['contacts'])) {
                                $syncContacts = new ParamsSyncMObjects();
                                if (!is_array($data['contacts']) && count($data['contacts']) == 1) {
                                    $data['contacts'] = array($data['contacts']);
                                }

                                foreach ($data['contacts'] as $contact) {
                                    $syncContacts->add($contact);
                                }

                                $opp = null;
                                if (!empty($data['opportunity_contact']) && is_string($data['opportunity_contact'])) {
                                    $bean = BeanFactory::getBean('Opportunities', $data['opportunity_contact']);
                                    if (!empty($bean->id) && $bean->id === $data['opportunity_contact']) {
                                        $opp = $bean;
                                    }
                                } elseif (!empty($data['opportunity_contact'])) {
                                    $opp = $data['opportunity_contact'];
                                }
                                $this->syncContacts($mkto, $syncContacts, $opp);
                            }
                        }
                        break;
                }
            } catch (Exception $e) {
                $GLOBALS['log']->fatal($mkto->logException($e));
            }
            return true;
        }
    }

    /**
     * handles the update of related contacts
     * @param ext_soap_marketo $mkto
     * @param ParamsSyncMObjects $contactsToSynchronize
     * @param Opportunity $opp
     */
    private function syncContacts(
        ext_soap_marketo $mkto,
        ParamsSyncMObjects $contactsToSynchronize,
        Opportunity $opp = null
    ) {
        $results = $mkto->syncMObjects($contactsToSynchronize);

        if (!is_array($results->result->mObjStatusList->mObjStatus)) {
            $results->result->mObjStatusList->mObjStatus = array($results->result->mObjStatusList->mObjStatus);
        }

        if (!empty($opp)) {
            $opp->load_relationship('contacts');
            foreach ($results->result->mObjStatusList->mObjStatus as $status) {
                if ($status->status == MObjStatusEnum::CREATED) {
                    $c = BeanFactory::getBean('Contacts', $status->externalKey->getAttrValue());
                    $c->logicHookDepth['before_save'] = 1000;
                    $c->logicHookDepth['after_relationship_add'] = 1000;

                    $opp->contacts->add(
                        $c,
                        array(
                            "mkto_id" => $status->id
                        )
                    );
                }
            }
        }
    }
}
