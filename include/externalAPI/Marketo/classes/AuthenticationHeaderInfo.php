<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

class AuthenticationHeaderInfo
{
    /**
     * @var string
     */
    public $mktowsUserId;

    /**
     * @var string
     */
    public $requestSignature;

    /**
     * @var string
     */
    public $requestTimestamp;


    function __construct($mktowsUserId, $requestSignature, $requestTimestamp)
    {
        $this->mktowsUserId = $mktowsUserId;
        $this->requestSignature = $requestSignature;
        $this->requestTimestamp = $requestTimestamp;
    }

    /**
     * @param string $mktowsUserId
     */
    public function setMktowsUserId($mktowsUserId)
    {
        $this->mktowsUserId = $mktowsUserId;
    }

    /**
     * @return string
     */
    public function getMktowsUserId()
    {
        return $this->mktowsUserId;
    }

    /**
     * @param string $requestSignature
     */
    public function setRequestSignature($requestSignature)
    {
        $this->requestSignature = $requestSignature;
    }

    /**
     * @return string
     */
    public function getRequestSignature()
    {
        return $this->requestSignature;
    }

    /**
     * @param string $requestTimestamp
     */
    public function setRequestTimestamp($requestTimestamp)
    {
        $this->requestTimestamp = $requestTimestamp;
    }

    /**
     * @return string
     */
    public function getRequestTimestamp()
    {
        return $this->requestTimestamp;
    }
}