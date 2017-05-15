<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

class ParamsListMObjects
{
}

class SuccessListMObjects
{
    public $result;
}

class ResultListMObjects
{
    public $objects;
}

class SuccessSyncMObjects extends SuccessListMObjects
{

}

class ResultSyncMObjects
{
    public $mObjStatusList;
}

class ArrayOfMObjStatus
{
    public $mObjStatus;
}

class MObjStatus
{
    public $id;
    public $externalKey;
    public $status;
    public $error;
}

/**
 * Class ParamsDescribeMObject
 */
class ParamsDescribeMObject
{
    public $objectName;

    function __construct($objectName)
    {
        $this->objectName = $objectName;
    }

    /**
     * @param mixed $objectName
     */
    public function setObjectName($objectName)
    {
        $this->objectName = $objectName;
    }

    /**
     * @return mixed
     */
    public function getObjectName()
    {
        return $this->objectName;
    }
}

class SuccessDescribeMObject
{

}

class ResultDescribeMObject
{
    public $metadata;
}

class MObjectMetadata
{
    public $name;
    public $description;
    public $isCustom;
    public $isVirtual;
    public $fieldList;
    public $updatedAt;

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $fieldList
     */
    public function setFieldList(ArrayOfMObjFieldMetadata $fieldList)
    {
        $this->fieldList = $fieldList;
    }

    /**
     * @return mixed
     */
    public function getFieldList()
    {
        return $this->fieldList;
    }

    /**
     * @param mixed $isCustom
     */
    public function setIsCustom($isCustom)
    {
        $this->isCustom = $isCustom;
    }

    /**
     * @return mixed
     */
    public function getIsCustom()
    {
        return $this->isCustom;
    }

    /**
     * @param mixed $isVirtual
     */
    public function setIsVirtual($isVirtual)
    {
        $this->isVirtual = $isVirtual;
    }

    /**
     * @return mixed
     */
    public function getIsVirtual()
    {
        return $this->isVirtual;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}

class ArrayOfMObjFieldMetadata
{
    public $field;
}

class MObjFieldMetadata
{
    public $name;
    public $description;
    public $displayName;
    public $sourceObject;
    public $dataType;
    public $size;
    public $isReadonly;
    public $isUpdateBlocked;
    public $isName;
    public $isPrimaryKey;
    public $isCustom;
    public $isDynamic;
    public $dynamicFieldRef;
    public $updatedAt;
}

class ParamsGetMObjects
{
    public $type;
    public $id;
    public $includeDetails;
    public $mObjCriteriaList;
    public $mObjAssociationList;
    public $streamPosition;

    public function __construct($type, $includeDetails = true)
    {
        $this->type = $type;
        $this->includeDetails = $includeDetails;
        $this->mObjCriteriaList = new ArrayOfMObjCriteria();
        $this->mObjAssociationList = new ArrayOfMObjAssociation();
    }
}

class ArrayOfMObjCriteria
{
    public $mObjCriteria;

    public function __construct()
    {
        $this->mObjCriteria = array();
    }
}

class ArrayOfMObjAssociation
{
    public $mObjAssociation;

    public function __construct()
    {
        $this->mObjAssociation = array();
    }
}

class MObjCriteria
{
    public $attrName;
    public $comparison;
    public $attrValue;
}

class MObjAssociation
{
    public $mObjType;
    public $id;
    public $externalKey;
}

class ResultGetMObjects
{
    public $returnCount;
    public $hasMore;
    public $newStreamPosition;
    public $mObjectList;
}

class ArrayOfMObject
{
    public $mObject;

    public function __construct()
    {
        $this->mObject = array();
    }
}


class MObject
{
    public $type;
    public $id;
    public $externalKey;
    public $createdAt;
    public $updatedAt;
    public $attribList;
    public $associationList;

    public function setAssociationList($associationList)
    {
        $this->associationList = $associationList;
    }

    public function getAssociationList()
    {
        return $this->associationList;
    }

    public function setAttribList(ArrayOfAttrib $attribList)
    {
        $this->attribList = $attribList;
    }

    public function getAttribList()
    {
        return $this->attribList;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setExternalKey($externalKey)
    {
        $this->externalKey = $externalKey;
    }

    public function getExternalKey()
    {
        return $this->externalKey;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}

class ArrayOfAttrib
{
    public $attrib;

    public function __construct()
    {
        $this->attrib = array();
    }

    public function add($attribute)
    {
        $this->attrib[] = $attribute;
    }
}

class Attrib
{
    public $name;
    public $value;

    function __construct($name = null, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }


    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}

class ParamsSyncMObjects
{
    public $mObjectList;
    public $operation;

    function __construct($operation = 'UPSERT')
    {
        $this->operation = $operation;
        $this->mObjectList = array();
    }

    public function setMObjectList(ArrayOfMObject $mObjectList)
    {
        $this->mObjectList = $mObjectList;
    }

    public function add($mObject)
    {
        $this->mObjectList[] = $mObject;
    }

    public function getMObjectList()
    {
        return $this->mObjectList;
    }

    public function setOperation($operation)
    {
        $this->operation = $operation;
    }

    public function getOperation()
    {
        return $this->operation;
    }
}

class ParamsDeleteMObjects extends ParamsSyncMObjects
{
    function __construct()
    {
        parent::__construct("");
    }
}

class MObjStatusEnum
{
    const CREATED = "CREATED";
    const UPDATED = "UPDATED";
    const DELETED = "DELETED";
    const FAILED = "FAILED";
    const UNCHANGED = "UNCHANGED";
    const SKIPPED = "SKIPPED";
}

class SuccessDeleteMObjects extends SuccessListMObjects
{

}

class ResultDeleteMObjects extends ResultSyncMObjects
{

}