<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$dependencies['Opportunities']['readonly_mkto_sync'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($mkto_id, ""))', //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('mkto_id'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'mkto_sync',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['readonly_mkto_id'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true', //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('mkto_id'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'mkto_id',
                'value' => 'true',
            ),
        ),
    ),
);