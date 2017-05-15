<?php
/*
 * Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
 * pursuant to the terms of the End User License Agreement available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
 */

require_once('include/MVC/View/views/view.list.php');

class ActivityLogsViewList extends ViewList
{
    public function getModuleTitle()
    {
        return parent::getModuleTitle(false);
    }

    public function preDisplay()
    {
        parent::preDisplay();
        $this->lv->quickViewLinks = false;
        $this->lv->export = false;
        $this->lv->delete = false;
        $this->lv->select = false;
        $this->lv->mailMerge = false;
        $this->lv->email = false;
        $this->lv->multiSelect = false;
        $this->lv->overLib = false;
        $this->lv->quickViewLinks = false;
        $this->lv->mergeDuplicates = false;
        $this->lv->contextMenues = false;
        $this->lv->showMassupdateFields = false;
        $this->lv->mergeduplicates = false;
    }

}