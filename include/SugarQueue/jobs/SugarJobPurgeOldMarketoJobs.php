<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once 'include/externalAPI/Marketo/MarketoFactory.php';

/**
 * Class SugarJobPurgeOldMarketoJobs.
 *
 * Job for prune old deleted records from marketo queue table.
 */
class SugarJobPurgeOldMarketoJobs implements RunnableSchedulerJob
{
    /**
     * @inheritdoc
     */
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }

    /**
     * @inheritdoc
     */
    public function run($data)
    {
        /** @var \ext_soap_marketo $marketo */
        $marketo = MarketoFactory::getInstance(false);
        if ($marketo->isEnabled()) {
            $sugarConfig = \SugarConfig::getInstance();
            $purgeInterval = intval($sugarConfig->get('marketo_purge_interval', 0));
            if ($purgeInterval <= 0) {
                return true;
            }
            $sugarTimeDate = \TimeDate::getInstance();
            $dateToDelete = $this->job->db->quoted($sugarTimeDate->getNow()->modify("- $purgeInterval days")->asDb());
            $dbDateToDelete = $this->job->db->convert($dateToDelete, 'datetime');
            $this->job->db->query('DELETE FROM mkto_queue WHERE deleted = 1 AND date_entered < ' . $dbDateToDelete);
        }

        return true;
    }
}
