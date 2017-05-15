<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$job_strings[] = 'marketoSync';
$job_strings[] = 'marketoActivityLogSync';
$job_strings[] = 'marketoPurgeOldJobs';

function marketoSync()
{
    require_once('include/externalAPI/Marketo/MarketoFactory.php');
    require_once('include/SugarQueue/jobs/SugarJobUpdateMarketo.php');

    if (MarketoFactory::getInstance(false)->isEnabled()) {
        try {
            $marketo = MarketoFactory::getInstance(true);

            try {
                $sugarJobUpdateMarketo = new SugarJobUpdateMarketo();
                $sugarJobUpdateMarketo->setJob(null);
                $sugarJobUpdateMarketo->run(null);
            } catch (Exception $e) {

            }

            $marketo->addMarketoUpdateScheduler();
            $marketo->pollMarketoForLeadChanges();
        } catch (Exception $e) {
            $GLOBALS['log']->fatal($e->getMessage());
        }
    }

    return true;
}


function marketoActivityLogSync()
{
    require_once('include/externalAPI/Marketo/MarketoFactory.php');
    if (MarketoFactory::getInstance(false)->isEnabled()) {
        try {
            $marketo = MarketoFactory::getInstance(true);
            $marketo->pollMarketoForLeadActivityChanges();
        } catch (Exception $e) {
            $GLOBALS['log']->fatal($e->getMessage());
        }
    }

    return true;
}

/**
 * Job for prune old deleted records from marketo queue table.
 *
 * @param \SchedulersJob $job
 *
 * @return bool
 */
function marketoPurgeOldJobs(\SchedulersJob $job)
{
    require_once 'include/SugarQueue/jobs/SugarJobPurgeOldMarketoJobs.php';
    try {
        $sugarJob = new SugarJobPurgeOldMarketoJobs();
        $sugarJob->setJob($job);
        $sugarJob->run(null);
    } catch (Exception $e) {
        $GLOBALS['log']->fatal($e->getMessage());
    }

    return true;
}
