<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once('include/externalAPI/Marketo/MarketoFactory.php');
require_once('include/externalAPI/Marketo/classes/Leads.php');

class SugarJobGetMarketoActivities implements RunnableSchedulerJob
{
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }

    public function run($data)
    {
        if (MarketoFactory::getInstance(false)->isEnabled()) {

            try {
                if (!empty($data) && is_string($data)) {
                    $data = unserialize(base64_decode($data));
                }
                $mkto = MarketoFactory::getInstance(true, MarketoFactory::MARKETO);
                $doPage = true;
                $sp = new StreamPosition();
                $dtObj = new DateTime('2007-01-01', new DateTimeZone('UTC'));
                $sp->oldestCreatedAt = $dtObj->format(DATE_W3C);
                while ($doPage) {

                    $successGetLeadChanges = $mkto->getLeadChanges(
                        new ParamsGetLeadChanges($sp, new ActivityTypeFilter(new ArrayOfActivityType($mkto->getFilters(
                        ))), 1000, new LeadKeySelector(LeadKeyRef::IDNUM, ArrayOfString::withStringItem($data)))
                    );
                    if ($successGetLeadChanges->result->returnCount > 0) {
                        if ($successGetLeadChanges->result->returnCount == 1) {
                            $successGetLeadChanges->result->leadChangeRecordList->leadChangeRecord = array($successGetLeadChanges->result->leadChangeRecordList->leadChangeRecord);
                        }

                        foreach ($successGetLeadChanges->result->leadChangeRecordList->leadChangeRecord as $leadChangeRecord) {
                            $mkto->synchronizeActivityLogsToSugarCRM($leadChangeRecord);
                        }
                    } else {
                        $doPage = false;
                    }

                    $sp = $successGetLeadChanges->result->newStartPosition;
                }

            } catch (Exception $e) {
                MarketoFactory::getInstance(false)->logException($e);
            }

        }


        return true;
    }
}
