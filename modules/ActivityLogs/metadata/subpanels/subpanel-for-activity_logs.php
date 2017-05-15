<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

$subpanel_layout['list_fields'] = array(
    'id' =>
        array(
            'type' => 'id',
            'studio' => true,
            'vname' => 'LBL_ID',
            'width' => '5%',
            'default' => true,
        ),
    'name' =>
        array(
            'type' => 'name',
            'link' => true,
            'vname' => 'LBL_NAME',
            'width' => '25%',
            'default' => true,
        ),
    'description' =>
        array(
            'type' => 'text',
            'vname' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'width' => '45%',
            'default' => true,
        ),
    'campaign_name' =>
        array(
            'type' => 'varchar',
            'vname' => 'LBL_CAMPAIGN_NAME',
            'width' => '20%',
            'default' => true,
        ),
    'date_modified' =>
        array(
            'type' => 'datetime',
            'studio' =>
                array(
                    'portaleditview' => false,
                ),
            'readonly' => true,
            'vname' => 'LBL_DATE_MODIFIED',
            'width' => '5%',
            'default' => true,
        ),
);