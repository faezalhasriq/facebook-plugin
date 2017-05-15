<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/
class MarketoJobHandlerAccounts extends MarketoJobHandlerUsers {

    protected $targetModule = 'Accounts';
    /**
     * @inheritdoc
     */
    protected function handleRows($rows) {
        if (!(count($rows)> 0)) {
            return;
        }

        $row =$rows[0] ;
        $data = $row['data'];

        if (MarketoFactory::getInstance(false)->isEnabled()) {
            $this->markRowComplete($row['id']);
            $data = unserialize(base64_decode($data));
            $account = BeanFactory::getBean('Accounts', $data['record'], array('disable_row_level_security' => true));
            if (!empty($account->id)) {
                $account->load_relationship('contacts');
                $this->processRelated($account->contacts->get(), 'Contacts', $data['leadRecord']);
            }
        }
        return true;
    }

}
