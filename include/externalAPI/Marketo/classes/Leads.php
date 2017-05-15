<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once('include/externalAPI/Marketo/classes/MObjects.php');

interface LeadKeyRef
{
    const IDNUM = "IDNUM";
    const COOKIE = "COOKIE";
    const EMAIL = "EMAIL";
    const LEADOWNEREMAIL = "LEADOWNEREMAIL";
    const SFDCACCOUNTID = "SFDCACCOUNTID";
    const SFDCCONTACTID = "SFDCCONTACTID";
    const SFDCLEADID = "SFDCLEADID";
    const SFDCLEADOWNERID = "SFDCLEADOWNERID";
    const SFDCOPPTYID = "SFDCOPPTYID";
}

class LeadKey implements LeadKeyRef
{

    public $keyType;
    public $keyValue;

    function __construct($keyType = self::IDNUM, $keyValue = "")
    {
        $this->keyType = $keyType;
        $this->keyValue = $keyValue;
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * @param string $keyType
     */
    public function setKeyType($keyType)
    {
        $this->keyType = $keyType;
    }

    /**
     * @return string
     */
    public function getKeyValue()
    {
        return $this->keyValue;
    }

    /**
     * @param string $keyValue
     */
    public function setKeyValue($keyValue)
    {
        $this->keyValue = $keyValue;
    }
}

class ParamsGetLead
{
    public $leadKey;

    function __construct(LeadKey $leadKey)
    {
        $this->leadKey = $leadKey;
    }

    /**
     * @return LeadKey
     */
    public function getLeadKey()
    {
        return $this->leadKey;
    }

    /**
     * @param LeadKey $leadKey
     */
    public function setLeadKey(LeadKey $leadKey)
    {
        $this->leadKey = $leadKey;
    }
}

class SuccessGetLead extends SuccessListMObjects
{
}

class ResultGetLead
{
    public $count;
    public $leadRecordList;
}

class ArrayOfLeadRecord
{
    public $leadRecord;

    function __construct($leadRecords = array())
    {
        if (is_array($leadRecords)) {
            $this->leadRecord = $leadRecords;
        } else {
            if (is_object($leadRecords) && get_class($leadRecords) == "LeadRecord") {
                $this->leadRecord = array($leadRecords);
            }
        }
    }

    function addLeadRecord(LeadRecord $leadRecord)
    {
        $this->leadRecord[] = $leadRecord;
    }
}

class LeadRecord
{
    /**
     * @var int
     */
    public $Id;
    /**
     * @var string
     */
    public $Email;
    /**
     * @var string
     */
    public $ForeignSysPersonId;
    /**
     * @var string
     *     NOTE: ForeignSysType should follow the following restrictions
     *     You can have one of the following value
     *     CUSTOM
     *     SFDC
     *     NETSUITE
     */
    public $ForeignSysType;
    /**
     * @var (object)ArrayOfAttribute
     */
    public $leadAttributeList;

    function __construct(
        $id,
        $Email,
        $ForeignSysPersonId = null,
        $ForeignSysType = null,
        ArrayOfAttribute $leadAttributeList
    ) {
        $this->Email = $Email;
        $this->ForeignSysPersonId = $ForeignSysPersonId;
        $this->ForeignSysType = $ForeignSysType;
        $this->Id = $id;
        $this->leadAttributeList = $leadAttributeList;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    /**
     * @return string
     */
    public function getForeignSysPersonId()
    {
        return $this->ForeignSysPersonId;
    }

    /**
     * @param string $ForeignSysPersonId
     */
    public function setForeignSysPersonId($ForeignSysPersonId)
    {
        $this->ForeignSysPersonId = $ForeignSysPersonId;
    }

    /**
     * @return string
     */
    public function getForeignSysType()
    {
        return $this->ForeignSysType;
    }

    /**
     * @param string $ForeignSysType
     */
    public function setForeignSysType($ForeignSysType)
    {
        $this->ForeignSysType = $ForeignSysType;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param int $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getLeadAttributeList()
    {
        return $this->leadAttributeList;
    }

    /**
     * @param mixed $leadAttributeList
     */
    public function setLeadAttributeList(ArrayOfAttribute $leadAttributeList)
    {
        $this->leadAttributeList = $leadAttributeList;
    }

    /**
     * @param null $marketoCookie
     */
    public function setMarketoCookie($marketoCookie)
    {
        $this->marketoCookie = $marketoCookie;
    }

    /**
     * @return null
     */
    public function getMarketoCookie()
    {
        return $this->marketoCookie;
    }

    /**
     * @param boolean $returnLead
     */
    public function setReturnLead($returnLead)
    {
        $this->returnLead = $returnLead;
    }

    /**
     * @return boolean
     */
    public function getReturnLead()
    {
        return $this->returnLead;
    }
}

class ArrayOfAttribute
{
    public $attribute;

    function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }
}

class StreamPosition
{

    /**
     * @var dateTime
     */
    public $latestCreatedAt;
    /**
     * @var dateTime
     */
    public $oldestCreatedAt;
    /**
     * @var string
     */
    public $offset;

    /**
     * @var dateTime
     */
    /**
     * By default we are going to make sure that we have some information in the object
     * and set it to 6 months prior to today
     */
    public function __construct()
    {
        $dtzObj = new DateTimeZone('America/New_York');

        /* set the oldestCreatedAt to be the current date -1 month time */
        $dtObj = new DateTime('now', $dtzObj);
        $dtObj->sub(new DateInterval('P1M'));
        $this->oldestCreatedAt = $dtObj->format(DATE_W3C);

        $this->offset = 0;
    }

}

class LeadChangeRecord
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var dateTime
     */
    public $activityDateTime;

    /**
     * @var string
     */
    public $activityType;

    /**
     * @var string
     */
    public $mktgAssetName;

    /**
     * @var (object)ArrayOfAttribute
     */
    public $activityAttributes;

    /**
     * @var string
     */
    public $campaign;

    /**
     * @var string
     */
    public $mktPersonId;

}

class ArrayOfLeadChangeRecord
{
    public $leadChangeRecord;
}

class ResultGetLeadChanges
{
    public $returnCount;
    public $remainingCount;
    public $newStartPosition;
    public $leadChangeRecordList;
}

class ForeignSysType
{
    const CUSTOM = "CUSTOM";
    const SFDC = "SFDC";
    const NETSUITE = "NETSUITE";
}

class ParamsGetMultipleLeads
{
    public $leadSelector;
    public $lastUpdatedAt;
    public $streamPosition;
    public $batchSize;
    public $includeAttributes;

    function __construct(
        LeadSelector $leadSelector,
        DateTime $lastUpdatedAt = null,
        $streamPosition = null,
        $batchSize = null,
        ArrayOfString $includeAttributes = null
    ) {
        $this->setLeadSelector($leadSelector);
        $this->lastUpdatedAt = $lastUpdatedAt;
        $this->streamPosition = $streamPosition;
        $this->batchSize = $batchSize;
        $this->includeAttributes = $includeAttributes;
    }

    /**
     * @param null $batchSize
     */
    public function setBatchSize($batchSize)
    {
        $this->batchSize = $batchSize;
    }

    /**
     * @return null
     */
    public function getBatchSize()
    {
        return $this->batchSize;
    }

    /**
     * @param null $includeAttributes
     */
    public function setIncludeAttributes($includeAttributes)
    {
        $this->includeAttributes = $includeAttributes;
    }

    /**
     * @return null
     */
    public function getIncludeAttributes()
    {
        return $this->includeAttributes;
    }

    /**
     * @param null $lastUpdatedAt
     */
    public function setLastUpdatedAt($lastUpdatedAt)
    {
        $this->lastUpdatedAt = $lastUpdatedAt;
    }

    /**
     * @return null
     */
    public function getLastUpdatedAt()
    {
        return $this->lastUpdatedAt;
    }

    /**
     * @param \SoapVar $leadSelector
     */
    public function setLeadSelector(LeadSelector $leadSelector)
    {
        $this->leadSelector = new SoapVar($leadSelector, SOAP_ENC_OBJECT, get_class(
            $leadSelector
        ), "http://www.marketo.com/mktows/");
    }

    /**
     * @return \SoapVar
     */
    public function getLeadSelector()
    {
        return $this->leadSelector;
    }

    /**
     * @param null $streamPosition
     */
    public function setStreamPosition($streamPosition)
    {
        $this->streamPosition = $streamPosition;
    }

    /**
     * @return null
     */
    public function getStreamPosition()
    {
        return $this->streamPosition;
    }


}

abstract class LeadSelector
{

}

class LeadKeySelector extends LeadSelector implements LeadKeyRef
{
    public $keyType;
    public $keyValues;

    function __construct($keyType = self::IDNUM, ArrayOfString $keyValues = null)
    {
        $this->keyType = $keyType;
        $this->keyValues = $keyValues;
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * @param string $keyType
     */
    public function setKeyType($keyType)
    {
        $this->keyType = $keyType;
    }

    /**
     * @return string
     */
    public function getKeyValues()
    {
        return $this->keyValues;
    }

    /**
     * @param string $keyValues
     */
    public function setKeyValues(ArrayOfString $keyValues)
    {
        $this->keyValues = $keyValues;
    }


}

class LastUpdateAtSelector extends LeadSelector
{
    public $latestUpdatedAt;
    public $oldestUpdatedAt;

    function __construct($oldestUpdatedAt = null, $latestUpdatedAt = null)
    {
        $this->oldestUpdatedAt = $oldestUpdatedAt;
        $this->latestUpdatedAt = $latestUpdatedAt;

        if (empty($this->oldestUpdatedAt)) {
            $then = new DateTime("now");
            $then->sub(new DateInterval('P1Y'));
            $this->oldestUpdatedAt = $then->format(DateTime::W3C);
        }
    }


}

class StaticListSelector extends LeadSelector
{
    public $staticListName;
    public $staticListId;

    function __construct($staticListId = null, $staticListName = null)
    {
        $this->staticListId = $staticListId;
        $this->staticListName = $staticListName;
    }
}

class ArrayOfString
{
    public $stringItem;

    function __construct()
    {
    }

    static function withStringItem($stringItem)
    {
        $instance = new ArrayOfString();
        $instance->stringItem = $stringItem;

        return $instance;
    }

    /**
     * @return mixed
     */
    public function getStringItem()
    {
        return $this->stringItem;
    }

    /**
     * @param mixed $stringItem
     */
    public function setStringItem($stringItem)
    {
        $this->stringItem = $stringItem;
    }
}

class SuccessGetMultipleLeads extends SuccessListMObjects
{

}

class ResultGetMultipleLeads
{

    /**
     * @var int
     */
    public $returnCount;
    /**
     * @var int
     */
    public $remainingCount;
    /**
     * @var string
     */
    public $newStreamPosition;
    /**
     * @var (object)ArrayOfLeadRecord
     */
    public $leadRecordList;

}

class Attribute
{
    /**
     * @var string
     */
    public $attrName;

    /**
     * @var string
     */
    public $attrType;

    /**
     * @var string
     */
    public $attrValue;

    function __construct()
    {
    }

    public static function withAttrName($attrName)
    {
        $instance = new self();
        $instance->setAttrName($attrName);
        return $instance;
    }

    /**
     * @param string $attrName
     */
    public function setAttrName($attrName)
    {
        $this->attrName = $attrName;
    }

    /**
     * @return string
     */
    public function getAttrName()
    {
        return $this->attrName;
    }

    /**
     * @param string $attrType
     */
    public function setAttrType($attrType)
    {
        $this->attrType = $attrType;
    }

    /**
     * @return string
     */
    public function getAttrType()
    {
        return $this->attrType;
    }

    /**
     * @param string $attrValue
     */
    public function setAttrValue($attrValue)
    {
        $this->attrValue = $this->getNormalizedAttrValue($attrValue);
    }

    /**
     * Gets a value that is compatible with the Marketo API
     *
     * @param string $attrValue
     * @return string
     */
    protected function getNormalizedAttrValue($value)
    {
        if ($value === false) {
            return "0";
        }

        if ($value === true) {
            return "1";
        }

        if (is_null($value) || $value === "") {
            return " ";
        }

        return $this->removeInvalidXmlChars($value);
    }

    /**
     * @return string
     */
    public function getAttrValue()
    {
        return $this->attrValue;
    }

    /**
     * Removes invalid XML
     * @param string $s
     * @return string $result
     */
    protected function removeInvalidXmlChars($s)
    {
        $result = "";
        if (!empty($s)) {
            $slen = strlen($s);
            for ($i = 0; $i < $slen; $i++) {
                $ordValue = ord($s{$i});
                if (($ordValue == 0x9) ||
                    ($ordValue == 0xA) ||
                    ($ordValue == 0xD) ||
                    (($ordValue >= 0x20) && ($ordValue <= 0xD7FF)) ||
                    (($ordValue >= 0xE000) && ($ordValue <= 0xFFFD)) ||
                    (($ordValue >= 0x10000) && ($ordValue <= 0x10FFFF))
                ) {
                    $result .= $s{$i};
                }
            }
        }
        return $result;
    }
}

class ParamsSyncLead
{

    /**
     * @var (object)LeadRecord
     */
    public $leadRecord;

    /**
     * @var boolean
     */
    public $returnLead;

    /**
     * @var string
     */
    public $marketoCookie;

    function __construct($leadRecord = null, $returnLead = true, $marketoCookie = null)
    {
        $this->leadRecord = $leadRecord;
        $this->marketoCookie = $marketoCookie;
        $this->returnLead = $returnLead;
    }
}

class ParamsSyncMultipleLeads
{

    /**
     * @var (object)ArrayOfLeadRecord
     */
    public $leadRecordList;

    /**
     * @var boolean
     */
    public $dedupEnabled;

    function __construct($leadRecordList, $dedupEnabled = true)
    {
        $this->dedupEnabled = $dedupEnabled;
        $this->leadRecordList = $leadRecordList;
    }


}


class SuccessSyncLead
{
    /**
     * @var (object)ResultSyncLead
     */
    public $result;

}

class ResultSyncLead
{

    /**
     * @var int
     */
    public $leadId;

    /**
     * @var string
     *     NOTE: syncStatus should follow the following restrictions
     *     You can have one of the following value
     *     CREATED
     *     UPDATED
     *     FAILED
     */
    public $syncStatus;

    /**
     * @var (object)LeadRecord
     */
    public $leadRecord;

}

class SuccessSyncMultipleLeads
{

    /**
     * @var (object)ResultSyncMultipleLeads
     */
    public $result;

}


class ResultSyncMultipleLeads
{

    /**
     * @var (object)ArrayOfSyncStatus
     */
    public $syncStatusList;

}

class ArrayOfSyncStatus
{
    /**
     * @var array[0, unbounded] of (object)SyncStatus
     */
    public $syncStatus;

}

class ParamsMergeLeads
{
    public $winningLeadKeyList;
    public $losingLeadKeyLists;

    function __construct($winningLeadKeyList, $losingLeadKeyLists)
    {
        $this->winningLeadKeyList = $winningLeadKeyList;
        $this->losingLeadKeyLists = $losingLeadKeyLists;
    }
}

class ArrayOfKeyList
{
    public $keyList;

    function __construct($keyList)
    {
        $this->keyList = $keyList;
    }
}

class LeadSyncStatus
{
    const CREATED = "CREATED";
    const UPDATED = "UPDATED";
    const FAILED = "FAILED";
}

class ParamsGetLeadActivity
{
    public $leadKey;
    public $activityFilter;
    public $startPosition;
    public $batchSize;

    function __construct(
        LeadKey $leadKey,
        ActivityTypeFilter $activityFilter = null,
        StreamPosition $startPosition = null,
        $batchSize = null
    ) {
        $this->leadKey = $leadKey;
        $this->activityFilter = $activityFilter;
        $this->startPosition = $startPosition;
        $this->batchSize = $batchSize;
    }
}

class ArrayOfActivityType
{

    public $activityType;

    function __construct(array $activityType = null)
    {
        $this->activityType = $activityType;
    }
}

class ActivityTypeFilter
{

    public $includeTypes;
    public $excludeTypes;

    function __construct(ArrayOfActivityType $includeTypes = null, ArrayOfActivityType $excludeTypes = null)
    {
        $this->includeTypes = $includeTypes;
        $this->excludeTypes = $excludeTypes;
    }
}

class ParamsGetLeadChanges
{

    public $startPosition;
    public $activityFilter;
    public $batchSize;
    public $leadSelector;

    function __construct(
        StreamPosition $startPosition,
        ActivityTypeFilter $activityFilter = null,
        $batchSize = null,
        LeadSelector $leadSelector = null
    ) {
        $this->activityFilter = $activityFilter;
        $this->batchSize = $batchSize;
        $this->startPosition = $startPosition;
        if ($leadSelector != null) {
            $this->leadSelector = new SoapVar($leadSelector, SOAP_ENC_OBJECT, get_class(
                $leadSelector
            ), "http://www.marketo.com/mktows/");
        }
    }
}

class SuccessGetLeadChanges extends SuccessListMObjects
{

}

class ActivityRecord
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var dateTime
     */
    public $activityDateTime;

    /**
     * @var string
     */
    public $activityType;

    /**
     * @var string
     */
    public $mktgAssetName;

    /**
     * @var (object)ArrayOfAttribute
     */
    public $activityAttributes;

    /**
     * @var string
     */
    public $campaign;

    /**
     * @var string
     */
    public $personName;

    /**
     * @var string
     */
    public $mktPersonId;

    /**
     * @var string
     */
    public $foreignSysId;

    /**
     * @var string
     */
    public $orgName;

    /**
     * @var string
     */
    public $foreignSysOrgId;

    function __construct(
        $activityAttributes,
        $activityDateTime,
        $activityType,
        $campaign,
        $foreignSysId,
        $foreignSysOrgId,
        $id,
        $mktPersonId,
        $mktgAssetName,
        $orgName,
        $personName
    ) {
        $this->activityAttributes = $activityAttributes;
        $this->activityDateTime = $activityDateTime;
        $this->activityType = $activityType;
        $this->campaign = $campaign;
        $this->foreignSysId = $foreignSysId;
        $this->foreignSysOrgId = $foreignSysOrgId;
        $this->id = $id;
        $this->mktPersonId = $mktPersonId;
        $this->mktgAssetName = $mktgAssetName;
        $this->orgName = $orgName;
        $this->personName = $personName;
    }

    /**
     * @param mixed $activityAttributes
     */
    public function setActivityAttributes($activityAttributes)
    {
        $this->activityAttributes = $activityAttributes;
    }

    /**
     * @return mixed
     */
    public function getActivityAttributes()
    {
        return $this->activityAttributes;
    }

    /**
     * @param \dateTime $activityDateTime
     */
    public function setActivityDateTime($activityDateTime)
    {
        $this->activityDateTime = $activityDateTime;
    }

    /**
     * @return \dateTime
     */
    public function getActivityDateTime()
    {
        return $this->activityDateTime;
    }

    /**
     * @param string $activityType
     */
    public function setActivityType($activityType)
    {
        $this->activityType = $activityType;
    }

    /**
     * @return string
     */
    public function getActivityType()
    {
        return $this->activityType;
    }

    /**
     * @param string $campaign
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * @return string
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * @param string $foreignSysId
     */
    public function setForeignSysId($foreignSysId)
    {
        $this->foreignSysId = $foreignSysId;
    }

    /**
     * @return string
     */
    public function getForeignSysId()
    {
        return $this->foreignSysId;
    }

    /**
     * @param string $foreignSysOrgId
     */
    public function setForeignSysOrgId($foreignSysOrgId)
    {
        $this->foreignSysOrgId = $foreignSysOrgId;
    }

    /**
     * @return string
     */
    public function getForeignSysOrgId()
    {
        return $this->foreignSysOrgId;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $mktPersonId
     */
    public function setMktPersonId($mktPersonId)
    {
        $this->mktPersonId = $mktPersonId;
    }

    /**
     * @return string
     */
    public function getMktPersonId()
    {
        return $this->mktPersonId;
    }

    /**
     * @param string $mktgAssetName
     */
    public function setMktgAssetName($mktgAssetName)
    {
        $this->mktgAssetName = $mktgAssetName;
    }

    /**
     * @return string
     */
    public function getMktgAssetName()
    {
        return $this->mktgAssetName;
    }

    /**
     * @param string $orgName
     */
    public function setOrgName($orgName)
    {
        $this->orgName = $orgName;
    }

    /**
     * @return string
     */
    public function getOrgName()
    {
        return $this->orgName;
    }

    /**
     * @param string $personName
     */
    public function setPersonName($personName)
    {
        $this->personName = $personName;
    }

    /**
     * @return string
     */
    public function getPersonName()
    {
        return $this->personName;
    }


}

class ArrayOfActivityRecord
{

    /**
     * @var array[0, unbounded] of (object)ActivityRecord
     */
    public $activityRecord;

    function __construct(ActivityRecord $activityRecord)
    {
        $this->activityRecord = $activityRecord;
    }
}

class LeadActivityList
{

    /**
     * @var int
     */
    public $returnCount;

    /**
     * @var int
     */
    public $remainingCount;

    /**
     * @var (object)StreamPosition
     */
    public $newStartPosition;

    /**
     * @var (object)ArrayOfActivityRecord
     */
    public $activityRecordList;

}

class SuccessGetLeadActivity
{
    public $leadActivityList;

    function __construct(LeadActivityList $leadActivityList)
    {
        $this->leadActivityList = $leadActivityList;
    }
}
