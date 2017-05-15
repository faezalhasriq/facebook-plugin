<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$hook_array['before_save'][] = array(
    9999,
    'Opportunity changed listener',
    'include/externalAPI/Marketo/LogicHookController.php',
    'LogicHookController',
    'SugarBeanListener',
);
$hook_array['after_delete'][] = array(
    9999,
    'Opportunity deleted listener',
    'include/externalAPI/Marketo/LogicHookController.php',
    'LogicHookController',
    'SugarBeanListener',
);
$hook_array['after_relationship_add'][] = array(
    9999,
    'Handle addition of Contacts to an Opportunity',
    'include/externalAPI/Marketo/LogicHookController.php',
    'LogicHookController',
    'AddOpportunityPersonRole',
);
$hook_array['after_relationship_update'][] = array(
    9999,
    'Handle addition of Contacts to an Opportunity',
    'include/externalAPI/Marketo/LogicHookController.php',
    'LogicHookController',
    'AddOpportunityPersonRole',
);