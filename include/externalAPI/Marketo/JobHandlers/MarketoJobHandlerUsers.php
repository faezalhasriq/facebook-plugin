<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

class MarketoJobHandlerUsers extends MarketoJobHandlerBase {

    protected $rows_per_loop = 1;

    protected $loops = 10;

    protected $targetModule = 'Users';
    /**
     * @inheritdoc
     */
    protected function getRows() {
        $fetchedRows = array();
        $sql = "select * from {$this->table_name} where deleted = 0 AND bean_module in ('{$this->targetModule}') ORDER BY date_entered ASC";

        $results = $this->db->limitQuery($sql, 0, $this->rows_per_loop);

        while ($row = $this->db->fetchRow($results)) {
            $fetchedRows[] = $row;
        }
        return $fetchedRows;
    }
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
            $user = BeanFactory::getBean('Users', $data['record'], array('disable_row_level_security' => true));
            if (!empty($user->id)) {

                //User's doesn't have established relationships to Contacts or Leads; we are going to establish them
                $contacts =
                    array(
                        'name' => 'contacts',
                        'type' => 'link',
                        'relationship' => 'contacts_assigned_user',
                        'vname' => 'LBL_ASSIGNED_TO_USER',
                        'link_type' => 'one',
                        'module' => 'Users',
                        'bean_name' => 'User',
                        'source' => 'non-db',
                        'rname' => 'user_name',
                        'id_name' => 'assigned_user_id',
                        'table' => 'users',
                        'duplicate_merge' => 'enabled',
                    );

                $leads =
                    array(
                        'name' => 'leads',
                        'type' => 'link',
                        'relationship' => 'leads_assigned_user',
                        'vname' => 'LBL_ASSIGNED_TO_USER',
                        'link_type' => 'one',
                        'module' => 'Users',
                        'bean_name' => 'User',
                        'source' => 'non-db',
                        'rname' => 'user_name',
                        'id_name' => 'assigned_user_id',
                        'table' => 'users',
                        'duplicate_merge' => 'enabled',
                    );

                $user->contacts = new Link2('contacts', $user, $contacts);
                $user->leads = new Link2('leads', $user, $leads);


                $user->load_relationship('contacts');
                $user->load_relationship('leads');

                $this->processRelated($user->contacts->get(), 'Contacts', $data['leadRecord']);
                $this->processRelated($user->leads->get(), 'Leads', $data['leadRecord']);
            }
        }
        return true;
    }

    /**
     * processes related beans and adds scheduler if needed
     * @param array $related
     * @param $module
     * @param LeadRecord $leadRecord
     */
    protected function processRelated(array $related, $module, LeadRecord $leadRecord)
    {
        foreach ($related as $id) {
            $bean = BeanFactory::getBean($module, $id, array('disable_row_level_security' => true));
            $beanPrimaryEmail = MarketoHelper::getBeanPrimaryEmail($bean);
            if ($bean->mkto_sync && !empty($beanPrimaryEmail)) {

                $leadRecord->Email = $beanPrimaryEmail;
                $leadRecord->Id = $bean->mkto_id;

                $id = create_guid();
                $time = $GLOBALS['timedate']->nowDb();
                $data = base64_encode(serialize(array('id' => $bean->id, 'module' => $module, 'leadRec' => $leadRecord)));
                $action = (!empty($bean->mkto_id) && $bean->mkto_id > 0) ? "PUT" : "POST";
                $query = "INSERT INTO mkto_queue (id, bean_id, bean_module, date_entered, date_modified, deleted, action, data) values ('$id', '$bean->id', '$bean->module_name', '$time', '$time', 0, '{$action}',  '$data')";
                $this->db->query($query, true, "Error populating index queue for marketo");

                MarketoFactory::getInstance(false)->addMarketoUpdateScheduler();
            }
        }
    }

}
