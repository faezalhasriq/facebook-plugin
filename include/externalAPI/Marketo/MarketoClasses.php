<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once('include/connectors/sources/ext/soap/soap.php');

class LeadStatus
{

    /**
     * @var (object)LeadKey
     */
    public $leadKey;

    /**
     * @var boolean
     */
    public $status;

}

class ListKey
{

    /**
     * @var string
     *     NOTE: keyType should follow the following restrictions
     *     You can have one of the following value
     *     MKTOLISTNAME
     *     MKTOSALESUSERID
     *     SFDCLEADOWNERID
     */
    public $keyType;

    /**
     * @var string
     */
    public $keyValue;

}

class ResultListOperation
{

    /**
     * @var boolean
     */
    public $success;

    /**
     * @var (object)ArrayOfLeadStatus
     */
    public $statusList;

}

class ResultRequestCampaign
{

    /**
     * @var boolean
     */
    public $success;

}


class SyncStatus
{

    /**
     * @var int
     */
    public $leadId;

    /**
     * @var string
     *     NOTE: status should follow the following restrictions
     *     You can have one of the following value
     *     CREATED
     *     UPDATED
     *     UNCHANGED
     *     FAILED
     */
    public $status;

    /**
     * @var string
     */
    public $error;

}

class VersionedItem
{

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $description;

    /**
     * @var dateTime
     */
    public $timestamp;

}


class ArrayOfBase64Binary
{

    // You need to set only one from the following two vars

    /**
     * @var array[0, unbounded] of Plain Binary
     */
    public $base64Binary;

    /**
     * @var array[0, unbounded] of base64Binary
     */
    public $base64Binary_encoded;


}

class ArrayOfLeadKey
{

    /**
     * @var array[0, unbounded] of (object)LeadKey
     */
    public $leadKey;

}

class ArrayOfLeadStatus
{

    /**
     * @var array[0, unbounded] of (object)LeadStatus
     */
    public $leadStatus;

}


class ArrayOfVersionedItem
{

    /**
     * @var array[0, unbounded] of (object)VersionedItem
     */
    public $versionedItem;

}

class paramsListOperation
{

    /**
     * @var string
     *     NOTE: listOperation should follow the following restrictions
     *     You can have one of the following value
     *     ADDTOLIST
     *     ISMEMBEROFLIST
     *     REMOVEFROMLIST
     */
    public $listOperation;

    /**
     * @var (object)ListKey
     */
    public $listKey;

    /**
     * @var (object)ArrayOfLeadKey
     */
    public $listMemberList;

    /**
     * @var boolean
     */
    public $strict;

}

class paramsRequestCampaign
{

    /**
     * @var string
     *     NOTE: source should follow the following restrictions
     *     You can have one of the following value
     *     MKTOWS
     *     SALES
     */
    public $source;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var (object)ArrayOfLeadKey
     */
    public $leadList;

}


class successGetLeadActivity
{

    /**
     * @var (object)LeadActivityList
     */
    public $leadActivityList;

}

class successGetMultipleLeads
{

    /**
     * @var (object)ResultGetMultipleLeads
     */
    public $result;

}

class successListOperation
{

    /**
     * @var (object)ResultListOperation
     */
    public $result;

}

class successRequestCampaign
{

    /**
     * @var (object)ResultRequestCampaign
     */
    public $result;

}

// define the class map
class MktowsXmlSchema
{
// Do not change the indentation or line breaks below this comment.
// For the curious, it helps with merging new changes from the WSDL code generator.
    static public
        $class_map = array(
        "ActivityRecord" => "ActivityRecord",
        "ActivityTypeFilter" => "ActivityTypeFilter",
        "Attribute" => "Attribute",
        "AuthenticationHeaderInfo" => "AuthenticationHeaderInfo",
        "CampaignRecord" => "CampaignRecord",
        "LeadActivityList" => "LeadActivityList",
        "LeadChangeRecord" => "LeadChangeRecord",
        "LeadKey" => "LeadKey",
        "LeadRecord" => "LeadRecord",
        "LeadStatus" => "LeadStatus",
        "ListKey" => "ListKey",
        "ResultGetCampaignsForSource" => "ResultGetCampaignsForSource",
        "ResultGetLead" => "ResultGetLead",
        "ResultGetLeadChanges" => "ResultGetLeadChanges",
        "ResultGetMultipleLeads" => "ResultGetMultipleLeads",
        "ResultListOperation" => "ResultListOperation",
        "ResultRequestCampaign" => "ResultRequestCampaign",
        "ResultSyncLead" => "ResultSyncLead",
        "ResultSyncMultipleLeads" => "ResultSyncMultipleLeads",
        "StreamPosition" => "StreamPosition",
        "SyncStatus" => "SyncStatus",
        "VersionedItem" => "VersionedItem",
        "ArrayOfActivityRecord" => "ArrayOfActivityRecord",
        "ArrayOfActivityType" => "ArrayOfActivityType",
        "ArrayOfAttribute" => "ArrayOfAttribute",
        "ArrayOfBase64Binary" => "ArrayOfBase64Binary",
        "ArrayOfCampaignRecord" => "ArrayOfCampaignRecord",
        "ArrayOfLeadChangeRecord" => "ArrayOfLeadChangeRecord",
        "ArrayOfLeadKey" => "ArrayOfLeadKey",
        "ArrayOfLeadRecord" => "ArrayOfLeadRecord",
        "ArrayOfLeadStatus" => "ArrayOfLeadStatus",
        "ArrayOfSyncStatus" => "ArrayOfSyncStatus",
        "ArrayOfVersionedItem" => "ArrayOfVersionedItem",
        "paramsGetCampaignsForSource" => "paramsGetCampaignsForSource",
        "paramsGetLead" => "paramsGetLead",
        "paramsGetLeadActivity" => "paramsGetLeadActivity",
        "paramsGetLeadChanges" => "paramsGetLeadChanges",
        "paramsGetMultipleLeads" => "paramsGetMultipleLeads",
        "paramsListOperation" => "paramsListOperation",
        "paramsRequestCampaign" => "paramsRequestCampaign",
        "paramsSyncLead" => "paramsSyncLead",
        "paramsSyncMultipleLeads" => "paramsSyncMultipleLeads",
        "successGetCampaignsForSource" => "successGetCampaignsForSource",
        "successGetLead" => "successGetLead",
        "successGetLeadActivity" => "successGetLeadActivity",
        "successGetLeadChanges" => "successGetLeadChanges",
        "successGetMultipleLeads" => "successGetMultipleLeads",
        "successListOperation" => "successListOperation",
        "successRequestCampaign" => "successRequestCampaign",
        "successSyncLead" => "successSyncLead",
        "successSyncMultipleLeads" => "successSyncMultipleLeads"
    );
}