<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

class SuccessGetCampaignsForSource
{

    /**
     * @var (object)ResultGetCampaignsForSource
     */
    public $result;

}

class ResultGetCampaignsForSource
{

    /**
     * @var int
     */
    public $returnCount;

    /**
     * @var (object)ArrayOfCampaignRecord
     */
    public $campaignRecordList;

}

class ArrayOfCampaignRecord
{

    /**
     * @var array[0, unbounded] of (object)CampaignRecord
     */
    public $campaignRecord;

}

class CampaignRecord
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

}

class ParamsGetCampaignsForSource
{
    const MKTOWS = "MKTOWS";
    const SALES = "SALES";

    /**
     * @var string
     *     NOTE: source should follow the following restrictions
     *     You can have one of the following value
     *     MKTOWS
     *     SALES
     */
    public $source;

    /**
     * @var string
     */
    public $name;

    /**
     * @var boolean
     */
    public $exactName;

    function __construct($source, $name = "", $exactName = false)
    {
        $this->source = $source;
        $this->name = $name;
        $this->exactName = $exactName;
    }
}
