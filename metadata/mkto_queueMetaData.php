<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['mkto_queue'] = array(
    'table' => 'mkto_queue',
    'fields' => array(
        array(
            'name' => 'id',
            'dbType' => 'id',
            'type' => 'varchar',
            'len' => '36',
            'comment' => '',
        ),
        array(
            'name' => 'bean_id',
            'dbType' => 'id',
            'type' => 'varchar',
            'len' => '36',
            'comment' => 'FK to various beans\'s tables',
        ),
        array(
            'name' => 'bean_module',
            'type' => 'varchar',
            'len' => '100',
            'comment' => 'bean\'s Module',
        ),
        array(
            'name' => 'date_entered',
            'type' => 'datetime'
        ),
        array(
            'name' => 'date_modified',
            'type' => 'datetime'
        ),
        array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false
        ),
        array(
            'name' => 'action',
            'type' => 'varchar',
            'len' => '10',
            'default' => 'PUT',
            'required' => true
        ),
        array(
            'name' => 'data',
            'type' => 'json',
            'dbType' => 'longtext',
            'required' => true
        )
    ),
    'indices' => array(
        array(
            'name' => 'mktoque_idx_id',
            'type' => 'primary',
            'fields' => array('id')
        ),
        array(
            'name' => 'mktoque_idx_beans_bean_id',
            'type' => 'index',
            'fields' => array('bean_module', 'bean_id')
        ),
        array(
            'name' => 'idx_deleted_date_entered',
            'type' => 'index',
            'fields' => array('deleted', 'date_entered')
        ),
    ),
    'relationships' => array()
);
