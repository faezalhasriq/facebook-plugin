<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

/**
 * Class MarketoJobHandlerBase
 * Base interface for Marketo Job handling
 */
class MarketoJobHandlerBase {
    /**
     * rows to execute per row
     * @var integer
     */
    protected $rows_per_loop;
    /**
     * loops to execute per run
     * @var integer
     */
    protected $loops;
    /**
     * target module to update
     * @var string
     */
    protected $targetModule;
    /**
     * rows that have been updated by the handler
     * @var array
     */
    protected $completedRows = array();
    /**
     * db object for queries
     * @var
     */
    protected $db;
    /**
     * table to pull rows from
     * @var string
     */
    protected $table_name = "mkto_queue";

    public function __construct()
    {
        $this->db = DBManagerFactory::getInstance('mkto');

        // take default rows per loop or load from sugarConfig

        $config = SugarConfig::getInstance()->get('marketo');

        if (!empty($config[$this->targetModule]['rows_per_loop'])) {
            $this->rows_per_loop = $config[$this->targetModule]['rows_per_loop'];
        }
    }

    /**
     * runs update for number of rows times loops
     */
    public function run() {
        $count = 0;
        while ($count <= $this->loops) {
            // get rows
            $rows = $this->getRows();
            $count++;

            if (!empty($rows)) {
                // handle rows
                $this->handleRows($rows);
                // mark deleted complete rows
                $this->deleteCompleted();
            } else {
                break;
            }
        }
    }

    /**
     * gets rows to update
     * @return array
     */
    protected function getRows() {
        $fetchedRows = array();


        return $fetchedRows;
    }

    /**
     * handles rows to update
     * @param $rows array rows to update
     */
    protected function handleRows($rows) {

    }

    /**
     * marks a row completed
     * @param $id
     */
    protected function markRowComplete($id) {
        $this->completedRows[]=$id;
    }

    /**
     * deletes rows that have been marked completed
     */
    protected function deleteCompleted() {
        global $timedate;

        $time = $timedate->asDb($timedate->getNow());
        $inClause = implode("','", $this->completedRows);
        $query = "UPDATE {$this->table_name} SET deleted = 1, date_modified = '$time' WHERE id in ('{$inClause}')";
        $this->db->query($query);

        $this->completedRows = array();
    }

}
