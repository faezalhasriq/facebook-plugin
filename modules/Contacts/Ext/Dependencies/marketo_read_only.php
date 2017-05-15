<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$dependencies['Contacts']['readonly_mrkto2_inferred_country_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true', //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('mrkto2_inferred_country_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'mrkto2_inferred_country_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Contacts']['readonly_mrkto2_anonymousip_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true', //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('mrkto2_anonymousip_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'mrkto2_anonymousip_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Contacts']['readonly_mrkto2_inferred_company_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true', //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('mrkto2_inferred_company_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'mrkto2_inferred_company_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Contacts']['readonly_mrkto2_unsubscribed_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true', //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('mrkto2_unsubscribed_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'mrkto2_unsubscribed_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Contacts']['readonly_mrkto2_unsubscribed_date_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true', //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('mrkto2_unsubscribed_date_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'mrkto2_unsubscribed_date_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Contacts']['readonly_mrkto2_invalid_email_date_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true', //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('mrkto2_invalid_email_date_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'mrkto2_invalid_email_date_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Contacts']['readonly_mkto_id'] = array(
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