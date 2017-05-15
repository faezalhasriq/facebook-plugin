<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$module_name = 'ActivityLogs';
$viewdefs [$module_name] =
    array(
        'EditView' =>
            array(
                'templateMeta' =>
                    array(
                        'maxColumns' => '2',
                        'widths' =>
                            array(
                                0 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                                1 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                            ),
                        'useTabs' => false,
                        'tabDefs' =>
                            array(
                                'DEFAULT' =>
                                    array(
                                        'newTab' => false,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_EDITVIEW_PANEL1' =>
                                    array(
                                        'newTab' => false,
                                        'panelDefault' => 'expanded',
                                    ),
                            ),
                        'syncDetailEditViews' => true,
                    ),
                'panels' =>
                    array(
                        'default' =>
                            array(
                                0 =>
                                    array(
                                        0 => array(
                                            'name' => 'name',
                                            'type' => 'readonly',
                                        ),
                                        1 =>
                                            array(
                                                'name' => 'campaign_name',
                                                'type' => 'readonly',
                                                'label' => 'LBL_CAMPAIGN_NAME',
                                            ),
                                    ),
                                1 =>
                                    array(
                                        0 => array(
                                            'name' => 'description',
                                            'type' => 'readonly',
                                        ),
                                    ),
                            ),
                        'lbl_editview_panel1' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'date_modified',
                                                'comment' => 'Date record last modified',
                                                'label' => 'LBL_DATE_MODIFIED',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'date_entered',
                                                'comment' => 'Date record created',
                                                'label' => 'LBL_DATE_ENTERED',
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
?>
