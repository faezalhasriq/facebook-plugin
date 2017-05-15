<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$module_name = 'ActivityLogs';
$viewdefs[$module_name] =
    array(
        'base' =>
            array(
                'view' =>
                    array(
                        'list' =>
                            array(
                                'panels' =>
                                    array(
                                        0 =>
                                            array(
                                                'label' => 'LBL_PANEL_1',
                                                'fields' =>
                                                    array(
                                                        0 =>
                                                            array(
                                                                'name' => 'name',
                                                                'label' => 'LBL_NAME',
                                                                'default' => true,
                                                                'enabled' => true,
                                                                'link' => true,
                                                                'width' => '10%',
                                                            ),
                                                        1 =>
                                                            array(
                                                                'label' => 'LBL_DATE_MODIFIED',
                                                                'enabled' => true,
                                                                'default' => true,
                                                                'name' => 'date_modified',
                                                                'readonly' => true,
                                                                'width' => '10%',
                                                            ),
                                                        2 =>
                                                            array(
                                                                'name' => 'description',
                                                                'label' => 'LBL_DESCRIPTION',
                                                                'enabled' => true,
                                                                'sortable' => false,
                                                                'width' => '40%',
                                                                'default' => true,
                                                            ),
                                                        3 =>
                                                            array(
                                                                'name' => 'campaign_name',
                                                                'label' => 'LBL_CAMPAIGN_NAME',
                                                                'enabled' => true,
                                                                'width' => '10%',
                                                                'default' => true,
                                                            ),
                                                        4 =>
                                                            array(
                                                                'name' => 'date_entered',
                                                                'label' => 'LBL_DATE_ENTERED',
                                                                'enabled' => true,
                                                                'readonly' => true,
                                                                'width' => '10%',
                                                                'default' => false,
                                                            ),
                                                        5 =>
                                                            array(
                                                                'name' => 'mkto_id',
                                                                'label' => 'LBL_MKTO_ID',
                                                                'enabled' => true,
                                                                'width' => '10%',
                                                                'default' => false,
                                                            ),
                                                    ),
                                            ),
                                    ),
                                'orderBy' =>
                                    array(
                                        'field' => 'date_modified',
                                        'direction' => 'desc',
                                    ),
                            ),
                    ),
            ),
    );
