<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once('include/externalAPI/Marketo/MarketoFactory.php');
require_once('include/externalAPI/Marketo/classes/Leads.php');
require_once('include/externalAPI/Marketo/JobHandlers/MarketoJobHandlerBase.php');
require_once('include/externalAPI/Marketo/JobHandlers/MarketoJobHandlerContacts.php');
require_once('include/externalAPI/Marketo/JobHandlers/MarketoJobHandlerOpportunities.php');
require_once('include/externalAPI/Marketo/JobHandlers/MarketoJobHandlerLeads.php');
require_once('include/externalAPI/Marketo/JobHandlers/MarketoJobHandlerUsers.php');
require_once('include/externalAPI/Marketo/JobHandlers/MarketoJobHandlerAccounts.php');

class SugarJobUpdateMarketo implements RunnableSchedulerJob
{
    protected $job;
    protected $db;

    public function setJob(SchedulersJob $job = null)
    {
        $this->job = $job;
    }

    public function run($data)
    {
        if (MarketoFactory::getInstance(false)->isEnabled() && $this->isSchedulerEnabled()) {
            $contactsHandler = new MarketoJobHandlerContacts();
            $leadsHandler = new MarketoJobHandlerLeads();
            $oppsHandler = new MarketoJobHandlerOpportunities();
            $usersHandler = new MarketoJobHandlerUsers();
            $accountsHandler = new MarketoJobHandlerAccounts();

            $handlers = array(
                $contactsHandler,
                $leadsHandler,
                $oppsHandler,
                $usersHandler,
                $accountsHandler,
            );

            foreach($handlers as $handler) {
                $handler->run();
            }

            MarketoFactory::getInstance(false)->addMarketoUpdateScheduler();
        }
        return true;
    }

    /**
     * Is enabled Scheduler 'Check Marketo for changes to Leads'.
     * @return bool
     * @throws SugarQueryException
     */
    protected function isSchedulerEnabled()
    {
        /** @var Scheduler $schedulerList */
        $schedulerList = BeanFactory::getBean('Schedulers');
        $sugarQuery = new SugarQuery();
        $sugarQuery->from($schedulerList);
        $sugarQuery->where()->equals('job', 'function::marketoSync');
        $sugarQuery->where()->equals('status', 'Active');
        $result = $schedulerList->fetchFromQuery($sugarQuery);
        return (bool)$result;
    }
}
