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
                        'record' =>
                            array(
                                'panels' =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'panel_header',
                                                'label' => 'LBL_RECORD_HEADER',
                                                'header' => true,
                                                'fields' =>
                                                    array(
                                                        0 =>
                                                            array(
                                                                'name' => 'picture',
                                                                'type' => 'avatar',
                                                                'width' => 42,
                                                                'height' => 42,
                                                                'dismiss_label' => true,
                                                                'readonly' => true,
                                                            ),
                                                        1 => 'name',
                                                        2 =>
                                                            array(
                                                                'name' => 'favorite',
                                                                'label' => 'LBL_FAVORITE',
                                                                'type' => 'favorite',
                                                                'readonly' => true,
                                                                'dismiss_label' => true,
                                                            ),
                                                        3 =>
                                                            array(
                                                                'name' => 'follow',
                                                                'label' => 'LBL_FOLLOW',
                                                                'type' => 'follow',
                                                                'readonly' => true,
                                                                'dismiss_label' => true,
                                                            ),
                                                    ),
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'panel_body',
                                                'label' => 'LBL_RECORD_BODY',
                                                'columns' => 2,
                                                'labelsOnTop' => true,
                                                'placeholders' => true,
                                                'newTab' => false,
                                                'panelDefault' => 'expanded',
                                                'fields' =>
                                                    array(
                                                        0 =>
                                                            array(
                                                                'name' => 'assigned_user_name',
                                                            ),
                                                        1 =>
                                                            array(
                                                                'name' => 'campaign_name',
                                                                'label' => 'LBL_CAMPAIGN_NAME',
                                                            ),
                                                    ),
                                            ),
                                        2 =>
                                            array(
                                                'name' => 'panel_hidden',
                                                'label' => 'LBL_SHOW_MORE',
                                                'hide' => true,
                                                'columns' => 2,
                                                'labelsOnTop' => true,
                                                'placeholders' => true,
                                                'newTab' => false,
                                                'panelDefault' => 'expanded',
                                                'fields' =>
                                                    array(
                                                        0 => 'date_modified',
                                                        1 => 'date_entered',
                                                        2 =>
                                                            array(
                                                                'name' => 'description',
                                                                'span' => 12,
                                                            ),
                                                    ),
                                            ),
                                    ),
                                'templateMeta' =>
                                    array(
                                        'useTabs' => false,
                                    ),
                            ),
                    ),
            ),
    );
