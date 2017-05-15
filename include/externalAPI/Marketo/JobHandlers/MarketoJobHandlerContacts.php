<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

class MarketoJobHandlerContacts extends MarketoJobHandlerBase {

    const CONSOLE_DEBUG = false;

    protected $rows_per_loop = 250;

    protected $loops = 20;

    protected $targetModule = 'Contacts';

    public function __construct()
    {
        parent::__construct();
        $this->db = DBManagerFactory::getInstance('mkto');
        // take default rows per loop or load from sugarConfig

        $this->arrayOfLeadRecords = new ArrayOfLeadRecord();
    }
    /**
     * @inheritdoc
     */
    protected function getRows() {
        $rowsToProcess = array();

        $this->db = DBManagerFactory::getInstance('mkto');
        $sql = "select * from {$this->table_name} where deleted = 0 AND action in ('POST', 'PUT') AND bean_module = '{$this->targetModule}' ORDER BY date_entered ASC";

        $results = $this->db->limitQuery($sql, 0, $this->rows_per_loop);

        $this->arrayOfLeadRecords = new ArrayOfLeadRecord();
        while ($row = $this->db->fetchRow($results)) {
            $data = unserialize(base64_decode($row['data']));
            $this->arrayOfLeadRecords->addLeadRecord($data['leadRec']);
            $rowsToProcess[] = $row;
        }

        return $rowsToProcess;
    }
    /**
     * @inheritdoc
     */
    protected function handleRows($rows) {
        if (!(count($rows) > 0)) {
            return;
        }
        $this->processUpdates($rows, new ParamsSyncMultipleLeads($this->arrayOfLeadRecords));
    }

    /**
     * processes updates for rows for multiple leads/contacts
     * @param $data
     * @param $paramsSyncMultipleLeads
     * @return bool
     */
    private function processUpdates($data, $paramsSyncMultipleLeads)
    {
        try {
            $mkto = MarketoFactory::getInstance(true);

            if (self::CONSOLE_DEBUG) {
                if (!empty($paramsSyncMultipleLeads->leadRecordList->leadRecord)) {
                    $leadRecords = $paramsSyncMultipleLeads->leadRecordList->leadRecord;
                    foreach ($leadRecords AS $leadRecord) {
                        printf("\n-----------------------------------------------------------------------------------\n");
                        printf("***  Lead Record Being Synced to Marketo:  Marketo ID: %s  Email: %s ***\n",
                            $leadRecord->Id, $leadRecord->Email);
                        if (!empty($leadRecord->leadAttributeList)) {
                            $attributes = $mkto->getLeadAttributeList($leadRecord);
                            foreach ($attributes AS $attribute) {
                                printf("  ==> Attrtibute Name:%-28s  Value: %s\n",
                                    $attribute->attrName, $attribute->attrValue);
                            }
                        }
                        printf("-----------------------------------------------------------------------------------\n");
                    }
                }
            }

            $results = $mkto->syncMultipleLeads($paramsSyncMultipleLeads);

            if (empty($results)) {
                foreach ($data as $key => $value) {
                    /**
                     * These records Failed to Sync - Error has been Logged
                     * Mark the records Complete so they are not re-processed
                     * Log the Records so that they can be manually processed if/as needed
                     */
                    $this->markRowComplete($data[$key]['id']);
                    $edata = "MODULE={$data[$key]['bean_module']} ID={$data[$key]['bean_id']}";
                    $GLOBALS['log']->fatal("SYNC FAILED - Record Not Synced to Marketo: {$edata}");
                }
            } else {
                if (!is_array($results->result->syncStatusList->syncStatus)) {
                    $results->result->syncStatusList->syncStatus = array($results->result->syncStatusList->syncStatus);
                }

                foreach ($results->result->syncStatusList->syncStatus as $key => $value) {
                    $this->markRowComplete($data[$key]['id']);
                    $bean = BeanFactory::getBean(
                        $data[$key]['bean_module'],
                        $data[$key]['bean_id'],
                        array('disable_row_level_security' => true)
                    );
                    $bean->update_date_modified = false;
                    $bean->update_modified_by = false;
                    $bean->update_date_entered = false;
                    $bean->set_created_by = false;
                    $bean->in_workflow = true;
                    if (empty($bean->id)) {
                        continue;
                    }

                    switch ($value->status) {

                        case LeadSyncStatus::FAILED:
                            // Lead has been deleted from Marketo, so remove the MKTO Lead ID from SugarCRM
                            if (isset($value->error) && strpos($value->error, MarketoError::ERR_LEAD_NOT_FOUND) === 0) {
                                $bean->mkto_id = null;
                                $bean->mkto_sync = 0;
                                $bean->save(false);

                                if ($bean->load_relationship('nepo_activity_log')) {
                                    foreach ($bean->nepo_activity_log->get() as $activityLogId) {
                                        $activityLog = BeanFactory::getBean(
                                            'NEPO_ActivityLog',
                                            $activityLogId,
                                            array('disable_row_level_security' => true)
                                        );
                                        if (!empty($activityLog->id)) {
                                            $activityLog->mark_deleted($activityLog->id);
                                        }
                                    }
                                }
                            }
                            break;
                        case LeadSyncStatus::UPDATED:
                            if ($bean->mkto_id == $value->leadId) {
                                break;
                            }
                        case LeadSyncStatus::CREATED:
                        default:
                            $bean->mkto_id = $value->leadId;
                            $bean->save(false);

                            //if this is a contact then we want to update any of the opportunities
                            if (strtolower($bean->table_name) === 'contacts') {
                                $bean->load_relationship('opportunities');
                                foreach ($bean->opportunities->get() as $opportunityId) {
                                    $opportunity = BeanFactory::getBean(
                                        'Opportunities',
                                        $opportunityId,
                                        array('disable_row_level_security' => true)
                                    );

                                    if ($opportunity->mkto_sync) {
                                        $opportunity->update_date_modified = false;
                                        $opportunity->update_modified_by = false;
                                        $opportunity->save(false);
                                    }
                                }
                            }
                    }
                }
            }
        } catch (Exception $e) {
            $mkto->logException($e, "SugarJobUpdateMarketo error: ");
            return false;
        }

        return true;
    }

}
