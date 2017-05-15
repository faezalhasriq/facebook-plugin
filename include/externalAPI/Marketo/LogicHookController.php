<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once("include/externalAPI/Marketo/MarketoFactory.php");
require_once("include/externalAPI/Marketo/classes/Leads.php");
require_once("include/externalAPI/Marketo/classes/MObjects.php");


class LogicHookController
{
    const CONSOLE_DEBUG = false;

    /**
     *
     * The LogicHookController listens for changes to SugarCRM records. It then looks if any of the fields
     * mapped to Marketo have changed. If they have changed, schedule a post or put to Marketo
     *
     * @param SugarBean $bean must be bean of type: Leads, Contacts, Opportunities, Accounts or Users
     * @param $event
     * @param $arguments
     */
    public function SugarBeanListener(SugarBean $bean, $event, $arguments)
    {
        $marketo = MarketoFactory::getInstance(false);
        // We ONLY send updates to Marketo if the connector is enabled
        if ($marketo->isEnabled()) {
            switch (strtolower(MarketoHelper::getObjectName($bean))) {
                case "lead":
                case "leads":
                    // Once a lead has been converted to a contact, no further updates are synced as 'Lead'
                    $syncBean = $marketo->verifyLeadSync($bean);
                    if (!$syncBean) {
                        return;
                    }
                    return $this->LeadsAndContactsUpdater($bean, $event, $arguments);
                case "contact":
                case "contacts":
                    return $this->LeadsAndContactsUpdater($bean, $event, $arguments);
                case "opportunity":
                case "opportunities":
                    return $this->OpportunitiesUpdater($bean, $event, $arguments);
                case "account":
                case "accounts":
                    return $this->AccountsUpdater($bean, $event, $arguments);
                case "user":
                case "users":
                case "employee":
                case "employees":
                    $bean->module_name = 'Users';
                    return $this->UsersUpdater($bean, $event, $arguments);
                default:
                    throw new SugarException("MARKETO_UPDATE_HOOK_EXCEPTION", null, $bean->getObjectName(
                    ), "Module passed to LogicHook updateMarketo is not supported");
            }
        }
    }

    /**
     * insert
     * @param $bean
     * @param $action
     * @param $data
     */

    protected function MarketoQueueInsert($bean, $action, $data) {
        global $timedate, $dictionary;

        // Make sure we don't insert similar records to queue. Is needed mainly for old Sugar Workflows.
        static $insertedRegistry = array();
        if (!isset($insertedRegistry[$bean->object_name][$bean->id])) {
            $insertedRegistry[$bean->object_name][$bean->id] = $data;
        } elseif ($insertedRegistry[$bean->object_name][$bean->id] === $data) {
            return;
        }

        $db = DBManagerFactory::getInstance('marketo');
        $id = create_guid();
        $time = $timedate->asDb($timedate->getNow());
        $insertData = array(
            'id' => $id,
            'bean_id' => $bean->id,
            'bean_module' => $bean->module_name,
            'date_entered' => $time,
            'date_modified' => $time,
            'deleted' => 0,
            'action' => $action,
            'data' => $data,
        );

        if (!isset($dictionary['mkto_queue'])) {
             include_once('metadata/mkto_queueMetaData.php');
        }

        $fieldDefKeys = array_keys($insertData);
        $fields = $dictionary['mkto_queue']['fields'];

        $fieldDefs = array();

        foreach ($fields as $defs) {
            if (isset($defs['name']) && in_array($defs['name'], $fieldDefKeys)) {
                $fieldDefs[$defs['name']] = $defs;
            }
        }

        foreach ($fieldDefKeys as $key) {
            if (!isset($fieldDefs[$key])) {
                $fieldDefs[$key] = array('name' => $key);
            }
        }
        
        // Calling insertParams because some databases need special handling for clob/blob fields
        $db->insertParams('mkto_queue', $fieldDefs, $insertData, null, true, $db->usePreparedStatements);

    }

    /**
     * LeadsAndContactsUpdater
     *
     * Look for changes to fields in Leads or Contacts. If there are changes then we need to spawn off a Job to apply those
     * changes to all Contacts that are synchronized with Marketo.
     *
     * @param $bean
     * @param $event
     * @param $arguments
     * @return bool|string
     */
    protected function LeadsAndContactsUpdater($bean, $event, $arguments)
    {
        $dateTime = new SugarDateTime("now", new DateTimeZone('UTC'));
        $currentDate = $dateTime->asDbDate(false);

        $currentEmailSettings = $this->getCurrentEmailStatus($bean);

        /*
         * Only synchronize if the Sync to Marketo Field is turned on
         * and if user has an Primary Email Address
         */

        // only fill fields on existing beans
        if(is_array($bean->fetched_row)) {
            $bean->fill_in_relationship_fields();
        }

        $beanEmail = MarketoHelper::getBeanPrimaryEmail($bean);

        if ($event != "after_delete") {
            // If Email fields are not yet set, set them.
            if (empty($beanEmail)) {
                return "EMAIL ADDRESS HAS NOT BEEN SET";
            }
        }

        if (!empty($bean->mkto_id)) {
            $bean->mkto_sync = true;
        }

        if (!$bean->mkto_sync) {
            return;
        }

        $marketo = MarketoFactory::getInstance(false);

        $update = false;
        if ($event == "before_save") {
            if (empty($bean->mkto_id)) {
                $bean->initialMarketoImport = true;   // mkto_sync is true and we do not have an id
            }

            if (!empty($bean->marketo)) {        // MARKETO
                $newOptout = (bool) $bean->marketo['new_opt_out'];
                $newInvalid = (bool) $bean->marketo['new_invalid_email'];
                unset($bean->marketo);
            } else {
                $newOptout = (bool) $bean->email_opt_out;
                $newInvalid = (bool) $bean->invalid_email;
            }

            $bean->email_opt_out = $newOptout;
            $bean->invalid_email = $newInvalid;
            if ($newOptout != $currentEmailSettings['opt_out'] ||
                ($newOptout && empty($bean->mrkto2_unsubscribed_date_c))
            ) {
                $update = true;
                if ($newOptout) {
                    $bean->mrkto2_unsubscribed_date_c = $currentDate;
                    $bean->mrkto2_unsubscribed_c = true;
                } else {
                    $bean->mrkto2_unsubscribed_date_c = '';
                    $bean->mrkto2_unsubscribed_c = false;
                }
            }
            if ($newInvalid != $currentEmailSettings['invalid_email'] ||
                ($newInvalid && empty($bean->mrkto2_invalid_email_date_c))
            ) {
                $update = true;
                $bean->fetched_row['invalid_email'] = $currentEmailSettings['invalid_email'];
                if ($newInvalid) {
                    $bean->mrkto2_invalid_email_date_c = $currentDate;
                    $bean->invalid_email = true;
                } else {
                    $bean->mrkto2_invalid_email_date_c = '';
                    $bean->invalid_email = false;
                }
            }

            if (self::CONSOLE_DEBUG) {
                if ($update) {
                    printf(
                        "\n ---- LogicHookController UPDATE: ---- %s -- %s  %s %s\n   optout: %0d=>%0d:%0d  date=%s\n   invalid: %0d=>%0d  date=%s\n\n",
                        $bean->module_name,
                        $bean->id,
                        $bean->first_name,
                        $bean->last_name,
                        $currentEmailSettings['opt_out'],
                        $newOptout,
                        $bean->mrkto2_unsubscribed_c,
                        $bean->mrkto2_unsubscribed_date_c,
                        $currentEmailSettings['invalid_email'],
                        $newInvalid,
                        $bean->mrkto2_invalid_email_date_c
                    );
                } else {
                    printf("\n ---- LogicHookController NO UPDATE  ---- \n\n");
                }
            }

            $attributes = $this->getAttributes($bean, $marketo);

            if ($update) {
                $bean->custom_fields->bean = $bean;
                $bean->custom_fields->save(true);
                $bean->custom_fields = null;
            }
        }


        if (!empty($attributes) || $bean->assigned_user_id != $bean->fetched_row['assigned_user_id']) {

            $attribute = new Attribute();
            $attribute->setAttrName('sugarcrm_deleted');
            $attribute->setAttrValue($event == "after_delete");
            $attributes[] = $attribute;

            if ($bean->module_name === "Contacts" && !empty($bean->account_id)) {
                $account = BeanFactory::getBean("Accounts", $bean->account_id);
                $account->initialMarketoImport = true;

                $attributes = array_merge($attributes, $this->getAttributes($account, $marketo));
            }

            $user = BeanFactory::getBean("Users", $bean->assigned_user_id);
            $user->initialMarketoImport = true;
            $attributes = array_merge($attributes, $this->getAttributes($user, $marketo));

            if ($marketo->getFieldsWithParams('marketo', 'sugarcrm_type')) {
                $attribute = new Attribute();
                $attribute->attrName = 'sugarcrm_type';
                $attribute->attrValue = $bean->module_name;
                $attributes[] = $attribute;
            }

            if ($marketo->getFieldsWithParams('marketo', 'sugarcrm_id')) {
                $attribute = new Attribute();
                $attribute->attrName = 'sugarcrm_id';
                $attribute->attrValue = $bean->id;
                $attributes[] = $attribute;
            }

            $leadRecord = new LeadRecord($bean->mkto_id, $beanEmail, null, null, new ArrayOfAttribute($attributes));

            $data = base64_encode(
                serialize(
                    array(
                        'id' => $bean->id,
                        'module' => ucwords(strtolower($bean->table_name)),
                        'leadRec' => $leadRecord
                    )
                )
            );
            $action = (!empty($bean->mkto_id) && $bean->mkto_id > 0) ? "PUT" : "POST";
            $this->MarketoQueueInsert($bean, $action, $data);
            $marketo->addMarketoUpdateScheduler();
        }
        return true;
    }


    /**
     * OpportunitiesUpdater
     *
     * Look for changes to fields in Opportunities. If there are changes then we need to spawn off a Job to apply those
     * changes to all Contacts that are synchronized with Marketo.
     *
     * @param $bean
     * @param $event
     * @param $arguments
     * @return bool|string
     */

    protected function OpportunitiesUpdater($bean, $event, $arguments)
    {
        global $app_list_strings, $current_user;
        $data = array('opportunity' => null, 'contacts' => array(), 'action' => 'UPSERT');

        if (MarketoFactory::getInstance(false, MarketoFactory::OPPORTUNITY)->isEnabled()) {
            if (!empty($bean->mkto_id)) {
                $bean->mkto_sync = true;
            }

            if ($bean->mkto_sync) {
                if ($event == 'after_delete' && !empty($bean->mkto_id)) {
                    $mObject = new MObject();
                    $mObject->setId($bean->mkto_id);
                    $mObject->setType(MarketoFactory::OPPORTUNITY);
                    $data['action'] = 'DELETE';
                    $data['opportunity'] = $mObject;
                    $this->MarketoQueueInsert($bean, $data['action'], base64_encode(serialize($data)));

                } else {
                    if ($event == 'before_save') {
                        $bean->mrkto2_is_won_c = $this->isOpportunityWon($bean);
                        $bean->mrkto2_is_closed_c = $this->isOpportunityClosed($bean);
                        $marketo = MarketoFactory::getInstance(false, MarketoFactory::OPPORTUNITY);

                        $attributes = $this->getAttributes($bean, $marketo);
                        // only update marketo if something has changed
                        if (!empty($attributes)) {
                            // further we only want to send the opportunity if there are contacts related
                            $sync = false;
                            $bean->load_relationship('contacts');
                            foreach ($bean->contacts->getBeans() as $contact) {
                                if (!empty($contact->mkto_id)) {
                                    $sync = true;
                                    break;
                                }
                            }

                            // RevenueLineItems Being created for a New Opportunity causes multiple syncs to
                            // to be queued, each of which creates a new mkto_id for same opportunity
                            // This test ensures that only a single mkto_id is created when a New Opportunity is created
                            if (!$sync && empty($bean->mkto_id) && empty($bean->MarketoCreateOpportunitySync)) {
                                $bean->MarketoCreateOpportunitySync = true;
                                $sync = true;
                            }

                            if ($sync) {
                                $mObject = new MObject();
                                $mObject->setType($marketo::OPPORTUNITY);
                                $mObject->setId($bean->mkto_id);


                                $externalKey = new Attribute();
                                $externalKey->attrName = "opportunities.id";
                                $externalKey->attrValue = $bean->id;

                                $mObject->setExternalKey($externalKey);
                                $dt = new DateTime($bean->date_entered, new DateTimeZone('UTC'));
                                $mObject->setCreatedAt($dt->format(DATE_W3C));
                                $dt = new DateTime($bean->date_modified, new DateTimeZone('UTC'));
                                $mObject->setUpdatedAt($dt->format(DATE_W3C));

                                $arrayofAttrib = new ArrayOfAttrib();
                                foreach ($attributes as $attribute) {
                                    if ($attribute->getAttrName() == 'Id') {
                                        continue;
                                    }

                                    $attrib = new Attrib();
                                    $attrib->setName($attribute->getAttrName());
                                    $attrib->setValue($attribute->getAttrValue());
                                    $arrayofAttrib->add($attrib);
                                }
                                $mObject->setAttribList($arrayofAttrib);

                                $data['opportunity'] = $mObject;
                                $this->MarketoQueueInsert($bean, '', base64_encode(serialize($data)));

                            }
                        }
                    }
                }
            }
        }

    }

    /**
     * AccountsUpdater
     *
     * Look for changes to fields in Accounts. If there are changes then we need to spawn off a Job to apply those
     * changes to all Contacts that are synchronized with Marketo.
     *
     * @param SugarBean $bean
     * @param $event
     * @param $arguments
     */
    protected function AccountsUpdater($bean, $event, $arguments)
    {
        global $current_user;

        $attributes = $this->getAttributes($bean, MarketoFactory::getInstance(false));
        if (!empty($attributes)) {
            $data = array(
                'record' => $bean->id,
                'leadRecord' => new LeadRecord(null, null, null, null, new ArrayOfAttribute($attributes)),
            );
            $this->MarketoQueueInsert($bean, '', base64_encode(serialize($data)));
        }
    }

    /**
     * If a person that was already synced with Marketo is added to an account we want to update corresponding
     * person information about newly linked account in Marketo.
     *
     * @param SugarBean $account
     * @param string $event
     * @param array $arguments
     */
    public function AddPersonToAccount(SugarBean $account, $event = 'after_relationship_add', $arguments = array())
    {
        $marketo = MarketoFactory::getInstance(false);
        $possiblePersonLinks = array('contacts');

        if (in_array($arguments['link'], $possiblePersonLinks) && $marketo->isEnabled()) {
            $account->load_relationship($arguments['link']);
            $where = array(
                'where' => array(
                    'lhs_field' => 'id',
                    'operator' => '=',
                    'rhs_value' => $arguments['related_id']
                ),
            );
            foreach ($account->$arguments['link']->getBeans($where) as $person) {
                if ($person->id == $arguments['related_id']) {
                    break;
                }
            }

            if (!empty($person) && !empty($person->mkto_id)) {
                $person->fetch($person->id);
                $this->LeadsAndContactsUpdater($person, 'before_save', $arguments);
            }
        }
    }

    /**
     * UsersUpdater
     *
     * Look for changes to fields in Users. If there are changes then we need to spawn off a Job to apply those
     * changes to all Contacts that are synchronized with Marketo.
     *
     * @param SugarBean $bean
     * @param $event
     * @param $arguments
     */
    protected function UsersUpdater($bean, $event, $arguments)
    {
        global $current_user;

        $attributes = $this->getAttributes($bean, MarketoFactory::getInstance(false));
        if (!empty($attributes)) {

            $data = array(
                'record' => $bean->id,
                'leadRecord' => new LeadRecord(null, null, null, null, new ArrayOfAttribute($attributes)),
            );
            $this->MarketoQueueInsert($bean, '', base64_encode(serialize($data)));
        }
    }

    /**
     * getAttributes
     *
     * Examine each of the mapped fields for the particular bean and look for changed values. Returns an array of changes
     *
     * @param SugarBean $bean
     * @param source $source
     * @return array
     */
    protected function getAttributes(SugarBean $bean, source $source)
    {
        $massUpdate = (isset($_REQUEST['__sugar_url']) && strpos(
                $_REQUEST['__sugar_url'],
                'MassUpdate'
            ) > 0) ? true : false;

        $attributes = array();

        $mapping = $source->getMapping();
        $fieldDefinitions = $source->getFieldDefs();

        $mapping['beans']['Contacts']['id'] = "mkto_id";
        $mapping['beans']['Leads']['id'] = "mkto_id";
        $mapping['beans']['Opportunities']['id'] = "mkto_id";

        $checkMktoId = (is_array($bean->getFieldDefinition('mkto_id'))) ? true : false;

        foreach ($mapping['beans'][$bean->module_name] as $mktoFieldName => $sugarFieldName) {
            if (isset($fieldDefinitions[$mktoFieldName]['marketo']) && isset($bean->$sugarFieldName) && isset($fieldDefinitions[$mktoFieldName]['type'])) {

                $attribute = Attribute::withAttrName($fieldDefinitions[$mktoFieldName]['marketo']);

                if ($attribute->getAttrName() == 'name') {
                    continue;
                }


                switch ($fieldDefinitions[$mktoFieldName]['type']) {
                    case 'enum':
                        $attribute->setAttrValue(
                            str_replace('^', '', str_replace('^,^', '; ', $bean->$sugarFieldName))
                        );
                        break;
                    case 'boolean':
                        $attribute->setAttrValue(
                            empty($bean->$sugarFieldName) ? 'false' : 'true'
                        );
                        break;
                    case 'date':
                        if (empty($bean->$sugarFieldName)) {
                            $attribute->setAttrValue("NULL");
                        } else {
                            $dt = new SugarDateTime($bean->$sugarFieldName, new DateTimeZone('UTC'));
                            $attribute->setAttrValue($dt->asDbDate());
                        }
                        break;
                    case 'datetime':
                        if (empty($bean->$sugarFieldName)) {
                            $attribute->setAttrValue("NULL");
                        } else {
                            $dt = new DateTime($bean->$sugarFieldName, new DateTimeZone('UTC'));
                            $attribute->setAttrValue($dt->format(DATE_W3C));
                        }
                        break;
                    case 'email':
                        $attribute->setAttrValue($this->getEmailToSync($bean, $sugarFieldName));
                        break;
                    default:
                        $attribute->setAttrValue($bean->$sugarFieldName);
                        break;
                }

                // ONLY Send Changed Data to Marketo
                if ($massUpdate ||
                    ($checkMktoId && empty($bean->mkto_id)) ||
                    (isset($bean->initialMarketoImport) && $bean->initialMarketoImport) ||
                    $this->isChanged($bean, $sugarFieldName, $fieldDefinitions, $mktoFieldName)
                ) {
                    $attributes[] = $attribute;
                }
            }
        }

        $GLOBALS['log']->debug(
            "ATTRIBUTES BEING PASSED TO MARKETO " . MarketoHelper::getObjectName($bean) . " " . print_r(
                $attributes,
                true
            )
        );
        return $attributes;
    }

    /**
     * Return Email for sync to marketo if it present.
     * @param SugarBean $bean
     * @param string $sugarFieldName
     * @return string
     */
    protected function getEmailToSync($bean, $sugarFieldName)
    {
        $emailValue = '';
        // If we have email => email mapping we should get primary email from emailAddresses
        if ($sugarFieldName == 'email') {
            return MarketoHelper::getBeanPrimaryEmail($bean);
        }

        // If we have the other mapping we should get it from array or string
        if (is_array($bean->$sugarFieldName)) {
            foreach ($bean->$sugarFieldName as $email) {
                if (array_key_exists('primary_address', $email) && $email['primary_address']) {
                    $emailValue = $email['email_address'];
                    break;
                }
            }
        } else {
            $emailValue = $bean->$sugarFieldName;
        }
        return $emailValue;
    }

    /**
     * Is field changed
     * @param SugarBean $bean
     * @param $sugarFieldName
     * @param $fieldDefinitions
     * @param $mktoFieldName
     * @return bool
     */
    protected function isChanged(SugarBean $bean, $sugarFieldName, $fieldDefinitions, $mktoFieldName)
    {
        $mktoName = strtolower($fieldDefinitions[$mktoFieldName]['name']);
        if ('email' == $fieldDefinitions[$mktoFieldName]['type']) {
            return $this->getEmailToSync($bean, $sugarFieldName) !== @$bean->downloaded_marketo_data[$mktoName];
        } else {
            return ($bean->$sugarFieldName != @$bean->fetched_row[$sugarFieldName]
                && $bean->$sugarFieldName !== @$bean->downloaded_marketo_data[$mktoName]);
        }
    }

    /**
     * When a Contact is removed from the Opportunity, we need to determine if this Contact has been associated to the
     * Opportunity in Marketo. If it has, we need to remove the relationship in Marketo.
     *
     * @param SugarBean $bean
     * @param $event
     * @param $arguments
     */
    function DeleteOpportunityPersonRole(SugarBean $bean, $event = 'before_relationship_delete', $arguments = array())
    {
        global $current_user;

        if ($arguments['link'] == 'opportunities') {
            $row = @$bean->opportunities->rows[$arguments['related_id']];
            if (is_array($row)) {
                if (!empty($row['mkto_id'])) {
                    $data = array('opportunity' => null, 'contacts' => array(), 'action' => 'DELETE');

                    $mObject = new MObject();
                    $mkto = MarketoFactory::getInstance(false);
                    $mObject->setType($mkto::OPPORTUNITY_PERSON_ROLE);
                    $mObject->setId($row['mkto_id']);
                    $data['contacts'][] = $mObject;
                    $this->MarketoQueueInsert($bean, '', base64_encode(serialize($data)));
                }
            }
        }
    }

    /**
     * If a contact is added to an opportunity that is synced with Marketo and the contact is also synced with
     * marketo, we want to link them all together on Marketo
     *
     * @param SugarBean $bean
     * @param string $event
     * @param array $arguments
     */
    function AddOpportunityPersonRole(SugarBean $bean, $event = 'after_relationship_add', $arguments = array())
    {
        global $current_user, $app_list_strings;

        if ($arguments['link'] == 'contacts' && $bean->mkto_sync
            && MarketoFactory::getInstance(false)->isEnabled()
        ) {
            $mkto = MarketoFactory::getInstance(false);

            $bean->load_relationship($arguments['link']);
            foreach ($bean->contacts->getBeans(
                         array(
                             'where' =>
                                 array(
                                     'lhs_field' => 'id',
                                     'operator' => '=',
                                     'rhs_value' => $arguments['related_id']
                                 )
                         )
                     ) as $contact) {
                if ($contact->id == $arguments['related_id']) {
                    break;
                }
            }

            if (!empty($contact->mkto_id)) {
                $bean->logicHookDepth['after_relationship_add'] = 1000;
                $bean->logicHookDepth['after_relationship_update'] = 1000;
                $data = array(
                    'opportunity' => null,
                    'contacts' => array(),
                    'action' => 'UPSERT',
                    'opportunity_contact' => $bean->id
                );
                $opportunityPersonRole = new MObject();
                $opportunityPersonRole->setType($mkto::OPPORTUNITY_PERSON_ROLE);
                $opportunityPersonRole->setId($contact->opportunity_role_mkto_id);

                $externalKey = new Attribute();
                $externalKey->attrName = "contacts.id";
                $externalKey->attrValue = $contact->id;
                $opportunityPersonRole->setExternalKey($externalKey);

                $arrayOfAttrib = new ArrayOfAttrib();
                $arrayOfAttrib->add(new Attrib('PersonId', $contact->mkto_id));
                $arrayOfAttrib->add(new Attrib('OpportunityId', $bean->mkto_id));
                $arrayOfAttrib->add(
                    new Attrib('Role', $app_list_strings['opportunity_relationship_type_dom'][empty($contact->opportunity_role) ? 'Other' : $contact->opportunity_role])
                );
                $arrayOfAttrib->add(
                    new Attrib('IsPrimary', (strpos($contact->opportunity_role, 'Primary') === 0) ? 'true' : 'false')
                );
                $opportunityPersonRole->setAttribList($arrayOfAttrib);
                $data['contacts'][] = $opportunityPersonRole;
                $this->MarketoQueueInsert($bean, '', base64_encode(serialize($data)));
            }
        }
    }

    protected function isOpportunityWon(Opportunity $opp)
    {
        $settings = Forecast::getSettings();
        $field = ($settings['forecast_by'] === 'Opportunities') ? 'sales_stage' : 'sales_status';
        $stages = isset($settings['sales_stage_won']) ? (array)$settings['sales_stage_won'] : array();

        return in_array($opp->$field, $stages);
    }

    protected function isOpportunityClosed(Opportunity $opp)
    {
        $settings = Forecast::getSettings();
        $field = ($settings['forecast_by'] === 'Opportunities') ? 'sales_stage' : 'sales_status';
        $stages = array_merge(
            isset($settings['sales_stage_won']) ? (array)$settings['sales_stage_won'] : array(),
            isset($settings['sales_stage_lost']) ? (array)$settings['sales_stage_lost'] : array()
        );

        return in_array($opp->$field, $stages);
    }

    /**
     * Get the Current Values for Opt_Out and Invalid_Email
     * @param SugarBean $bean
     * @return array
     */
    protected function getCurrentEmailStatus(SugarBean $bean)
    {
        if (!empty($bean->marketo)) {        // MARKETO
            $currentOptout  = (bool) $bean->marketo['current_opt_out'];
            $currentInvalid = (bool) $bean->marketo['current_invalid_email'];
        } else {
            $currentOptout  = (bool) $bean->email_opt_out;
            $currentInvalid = (bool) $bean->invalid_email;
            $beanPrimaryEmail = MarketoHelper::getBeanPrimaryEmail($bean);
            if (!empty($beanPrimaryEmail)) {
                $addresses = false;
                if (!empty($bean->emailAddress->fetchedAddresses)) {
                    $addresses = $bean->emailAddress->fetchedAddresses;
                } elseif (!empty($bean->email)) {
                    $addresses = $bean->email;
                }
                if (!empty($addresses)) {
                    foreach ($addresses as $address) {
                        if (strtolower($address['email_address']) === strtolower($beanPrimaryEmail)) {
                            $currentOptout = (bool) $address['opt_out'];
                            $currentInvalid = (bool) $address['invalid_email'];
                            break;
                        }
                    }
                }
            }
        }

        return array(
            "opt_out"  => $currentOptout,
            "invalid_email" => $currentInvalid,
        );
    }
}
