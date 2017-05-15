<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$dictionary['Lead']['fields']['activity_logs'] =
    array(
        'name' => 'activity_logs',
        'type' => 'link',
        'relationship' => 'activitylogs_leads',
        'source' => 'non-db',
        'vname' => 'LBL_ACTIVITY_LOGS',
    );