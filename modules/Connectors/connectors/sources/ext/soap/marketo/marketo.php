<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once 'include/connectors/sources/ext/soap/soap.php';
require_once 'include/connectors/utils/ConnectorUtils.php';
require_once 'modules/Connectors/connectors/sources/ext/soap/marketo/MarketoHelper.php';
require_once 'include/externalAPI/Marketo/classes/AuthenticationHeaderInfo.php';
require_once 'include/externalAPI/Marketo/classes/MarketoError.php';
require_once 'include/externalAPI/Marketo/classes/MObjects.php';
require_once 'include/externalAPI/Marketo/classes/Leads.php';
require_once 'include/SugarQueue/SugarJobQueue.php';

class ext_soap_marketo extends ext_soap
{
    // Change this value to true to enable debug output.
    const DEBUG = false;
    const CONSOLE_DEBUG = false;

    const CLIENT_TZ = 'America/New_York';

    const LEAD_RECORD = 'LeadRecord';
    const OPPORTUNITY = 'Opportunity';
    const OPPORTUNITY_PERSON_ROLE = 'OpportunityPersonRole';

    const MKTOWS_USER_ID = '';
    const MKTOWS_SECRET_KEY = '';

    const MKTOWS_NAMESPACE = 'http://www.marketo.com/mktows/';
    const SERVICE_NOT_ENABLED = "Marketo is not enabled";

    protected $accessKey;
    protected $secretKey;
    protected $assigned_user_id;
    protected $convert_score;
    protected $download_score;
    protected $get_details = false;
    protected $keep_accounts_syncd = false;
    protected $download_activity_log_by_default = false;
    protected $filters = false;
    protected $keep_email_opt_out_sync = true;
    protected $records_to_download = 100;
    protected $allowedModuleList;

    public function __construct()
    {
        global $app_list_strings;

        parent::__construct();

        $this->allowedModuleList = array(
            'Contacts' => 'Contacts',
            'Leads' => 'Leads',
            'Accounts' => 'Accounts',
            'Users' => 'Users',
        );

        foreach($this->allowedModuleList as $key => $name) {
            if(isset($app_list_strings['moduleList'][$key])) {
                $this->allowedModuleList[$key] = isset($app_list_strings['moduleList'][$key]);
            }
        }

        $this->_has_testing_enabled = true;
        $this->_enable_in_wizard = false;
        $this->_enable_in_admin_display = false;
        $this->_required_config_fields = array(
            'marketo_wsdl',
            'marketo_user_id',
            'marketo_shared_secret'
        );
        $this->_required_config_fields_for_button = array(
            'marketo_wsdl',
            'marketo_user_id',
            'marketo_shared_secret'
        );
    }

    /**
     * Verify if given secret matches the configured one
     * @param string $secret
     * @return boolean
     */
    public function isSecretValid($value)
    {
        $secret = $this->getProperty('marketo_shared_secret');
        return $this->secureStrCompare($value, $secret);
    }

    /**
     * Time attack safe string comparison, should consider hash_equals
     * instead for PHP >=5.6 which is time attack resistant out of the box.
     * @param string $str1
     * @param string $str2
     * @return boolean
     */
    protected function secureStrCompare($str1, $str2)
    {
        if (strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $ret = 0;
            for ($i = 0; $i < strlen($str1); $i++) {
                $ret |= (ord($str1[$i]) ^ ord($str2[$i]));
            }
            return $ret === 0;
        }
    }

    public function getDownloadScore()
    {
        return $this->download_score;
    }

    public function getConvertScore()
    {
        return $this->convert_score;
    }

    public function init()
    {
        parent::init();

        $this->secretKey = $this->getProperty('marketo_shared_secret');
        $soapEndPoint = $this->getProperty('marketo_wsdl');
        $this->assigned_user_id = $this->getProperty('assigned_user_id');

        $this->records_to_download = $this->getProperty('records_to_download');
        if (!is_numeric($this->records_to_download)) {
            $this->records_to_download = 100;
        }

        $this->download_score = $this->getProperty('download_score');
        if (empty($this->download_score)) {
            $this->download_score = 0;
        }

        $this->get_details = (isset($properties['get_details']) && ($properties['get_details'] == "on" || $properties['get_details'] == "1")) ? true : false;
        $this->keep_accounts_syncd = ((isset($properties['keep_accounts_syncd']) && $properties['keep_accounts_syncd'] == "1") || !isset($properties['keep_accounts_syncd'])) ? true : false;
        $this->download_activity_log_by_default = ((isset($properties['download_activity_log_by_default']) && $properties['download_activity_log_by_default'] == "1")) ? true : false;
        $this->filters = $this->getProperty('filter');
        $this->keep_email_opt_out_sync = true;


        $options = array(
            "connection_timeout" => 20,
            "location" => $soapEndPoint,
            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
            'classmap' =>
                array(
                    'ActivityRecord' => 'ActivityRecord',
                    'ArrayOfActivityRecord' => 'ArrayOfActivityRecord',
                    'ArrayOfAttrib' => 'ArrayOfAttrib',
                    'ArrayOfAttribute' => 'ArrayOfAttribute',
                    'ArrayOfLeadChangeRecord' => 'ArrayOfLeadChangeRecord',
                    'ArrayOfLeadRecord' => 'ArrayOfLeadRecord',
                    'ArrayOfMObject' => 'ArrayOfMObject',
                    'ArrayOfMObjFieldMetadata' => 'ArrayOfMObjFieldMetadata',
                    'ArrayOfMObjStatus' => 'ArrayOfMObjStatus',
                    'ArrayOfSyncStatus' => 'ArrayOfSyncStatus',
                    'Attrib' => 'Attrib',
                    'Attribute' => 'Attribute',
                    'LeadActivityList' => 'LeadActivityList',
                    'LeadChangeRecord' => 'LeadChangeRecord',
                    'LeadRecord' => 'LeadRecord',
                    'MObject' => 'MObject',
                    'MObjectMetadata' => 'MObjectMetadata',
                    'MObjFieldMetadata' => 'MObjFieldMetadata',
                    'MObjStatus' => 'MObjStatus',
                    'ResultDeleteMObjects' => 'ResultDeleteMObjects',
                    'ResultDescribeMObject' => 'ResultDescribeMObject',
                    'ResultGetLead' => 'ResultGetLead',
                    'ResultGetLeadChanges' => 'ResultGetLeadChanges',
                    'ResultGetMObjects' => 'ResultGetMObjects',
                    'ResultGetMultipleLeads' => 'ResultGetMultipleLeads',
                    'ResultListMObjects' => 'ResultListMObjects',
                    'ResultSyncLead' => 'ResultSyncLead',
                    'ResultSyncMObjects' => 'ResultSyncMObjects',
                    'ResultSyncMultipleLeads' => 'ResultSyncMultipleLeads',
                    'StreamPosition' => 'StreamPosition',
                    'SuccessDeleteMObjects' => 'SuccessDeleteMObjects',
                    'SuccessDescribeMObject' => 'SuccessDescribeMObject',
                    'SuccessGetLead' => 'SuccessGetLead',
                    'SuccessGetLeadActivity' => 'SuccessGetLeadActivity',
                    'SuccessGetLeadChanges' => 'SuccessGetLeadChanges',
                    'SuccessGetMultipleLeads' => 'SuccessGetMultipleLeads',
                    'SuccessListMObjects' => "SuccessListMObjects",
                    'SuccessSyncLead' => 'SuccessSyncLead',
                    'SuccessSyncMObjects' => 'SuccessSyncMObjects',
                    'SuccessSyncMultipleLeads' => 'SuccessSyncMultipleLeads',
                )
        );

        if (self::DEBUG) {
            $options["trace"] = true;
        }

        if (empty($soapEndPoint)) {
            return false;
        }

        $this->setProxyOptions($options);

        try {
            $this->_client = new SoapClient("$soapEndPoint?WSDL", $options);
            $this->_client->__setSoapHeaders($this->_getAuthenticationHeader());
        } catch (Exception $ex) {
            $this->logException($ex);
            return false;
        }

        return true;
    }

    /**
     * Get the config values encoded to string format to place into the custom modules directory
     * @param $key array key
     * @param $val array value
     */
    public function getConfigString($key, $val) {
        return override_value_to_string('config', $key, $val, false);
    }

    /**
     * Authentication Signature
     * Marketo API security uses a simple yet highly secure model, based on HMAC-SHA11 signatures with messages transmitted over HTTPS. A key advantage of this model is that it provides stateless authentication.
     * HMAC-SHA1 signatures require the following:
     *
     * A User ID (also called Access Key) that is transmitted with the service request
     * A Signature that is calculated using a shared secret-key and message content and is transmitted with the service request
     * A shared secret-key (also called Encryption Key) that is not transmitted with the service request
     * This security information is confirmed via Admin --> SOAP API within Marketo.
     *
     * The client program will calculate the HMAC-SHA1 signature using the shared secret-key and part of the request message content. The client must include a SOAP header, AuthenticationHeaderInfo, to pass authentication information with the SOAP message.
     *
     * @return SoapHeader
     */
    protected function _getAuthenticationHeader()
    {
        $dtzObj = new DateTimeZone(self::CLIENT_TZ);
        $dtObj = new DateTime('now', $dtzObj);
        $timestamp = $dtObj->format(DATE_W3C);
        $encryptString = $timestamp . $this->getProperty('marketo_user_id');

        $authenticationHeaderInfo = new AuthenticationHeaderInfo($this->getProperty('marketo_user_id'), hash_hmac(
            'sha1',
            $encryptString,
            $this->getProperty('marketo_shared_secret')
        ), $dtObj->format(DATE_W3C));
        $soapHdr = new SoapHeader(self::MKTOWS_NAMESPACE, 'AuthenticationHeader', $authenticationHeaderInfo);

        return $soapHdr;
    }

    /**
     * Sets proxy options from global proxy settings.
     *
     * @param array $options
     */
    protected function setProxyOptions(&$options)
    {
        $proxyConfig = Administration::getSettings('proxy');

        if (!empty($proxyConfig) &&
            !empty($proxyConfig->settings['proxy_on']) &&
            $proxyConfig->settings['proxy_on'] == 1
        ) {
            $options['proxy_host'] = $proxyConfig->settings['proxy_host'];
            $options['proxy_port'] = $proxyConfig->settings['proxy_port'];

            $options['stream_context'] = stream_context_create(array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ),
            ));

            if (!empty($proxyConfig->settings['proxy_auth'])) {
                $options['proxy_login'] = $proxyConfig->settings['proxy_username'];
                $options['proxy_password'] = $proxyConfig->settings['proxy_password'];
            }
        }
    }

    /**
     * test
     * This method is called from the administration components to make a live test
     * call to see if the configuration and connections are available
     *
     * @return boolean result of the test call false if failed, true otherwise
     */
    public function test()
    {
        if ($this->isEnabled()) {
            //We need to have the SoapClient enabled in PHP in order to access Marketo
            if (!class_exists('SoapClient')) {
                throw new Exception('Soap is not installed in your environment! Please add Soap to your PHP configuration');
            }

            //We need to have the ability to generate an HMAC-SHA1 signature, so we need to be sure that PHP has hash_hmac turned enabled.
            if (!function_exists('hash_hmac')) {
                throw new Exception('hash_hmac is not installed in your environment! Please add hash_hmac to your PHP configuration');
            }

            $this->listMObjects();
            $this->getSchema(self::LEAD_RECORD);
            //@todo We should make marketo independent from $_REQUEST in future
            $currentRequest = $_REQUEST;
            MarketoHelper::ValidateInstallation();
            $_REQUEST = $currentRequest;

            return true;
        } else {
            return false;
        }
    }

    /**
     * If Marketo has all of the fields filled in we indicate that Marketo is enabled.
     * @return bool
     */
    public function isEnabled()
    {
        $enabled = $this->getProperty('enabled');
        $wsdl = $this->getProperty('marketo_wsdl');
        $key = $this->getProperty('marketo_user_id');
        $secret = $this->getProperty('marketo_shared_secret');

        return ($enabled == 1 && !empty($wsdl) && !empty($key) && !empty($secret));
    }

    /**
     * This function returns the names of Marketo objects that can be used as input into the describeMObjects function for schema discovery operations.
     *
     * @return mixed
     * @throws Exception
     */
    public function listMObjects()
    {
        if ($this->isEnabled()) {
            return $this->_client->listMObjects(array(new ParamsListMObjects()));
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     *
     * describeMObject
     *
     * MObjects can be one of three types: Standard, custom or virtual. Standard and custom MObjects represent distinct entities, such as Lead or Company, while Virtual Objects, such as LeadRecord, are comprised of fields from one or more objects.  Virtual objects are convenience objects used within the API but do not exist within the Marketo application.
     *
     * This function returns the metadata for standard and virtual MObjects.  It takes in the Marketo object as input and returns the field attributes that are associated to that object.
     *
     * @param $objectName
     * @return mixed
     * @throws Exception
     */
    public function describeMObject($objectName)
    {
        if ($this->isEnabled()) {
            return $this->_client->describeMObject(new ParamsDescribeMObject($objectName));
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * getMObjects
     *
     * Retrieves one or more MObjects using a combination of criteria consisting of:
     *  • Zero or one unique ID, either the Marketo ID or external ID
     *  • Zero or more attribute filters as name/value/comparison trios
     *  • Zero or more associated object filters as object name/ID pairs
     * Returns a list of matching MObjects, all of a single type, up to 100 in a batch, and a stream position token for retrieving successive batches.
     * Special handling will be required to ensure that the resulting SQL query will perform well.
     *
     * @param ParamsGetMObjects $paramsGetMObjects
     * @return mixed
     * @throws Exception
     */
    public function getMObjects(ParamsGetMObjects $paramsGetMObjects)
    {
        if ($this->isEnabled()) {
            return $this->_client->getMObjects($paramsGetMObjects);
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * syncMObjects
     *
     * Accepts an array of MObjects to be created or updated, up to a maximum to 100 per call, and returns the outcome (status) of the operation (CREATED, UPDATED, FAILED, UNCHANGED, SKIPPED) and the Marketo IDs of the MObject(s). The API can be called in one of three operation modes:
     * INSERT - only insert new objects, skip existing objects,
     * UPDATE - only update existing objects, skip new objects, or
     * UPSERT - insert new objects and update existing objects.
     * In a single API call some updates may succeed and some may fail. An error message will be returned for each failure.
     *
     * @param ParamsSyncMObjects $paramsGetMObjects
     * @return mixed
     * @throws Exception
     */
    public function syncMObjects(ParamsSyncMObjects $paramsSyncMObjects)
    {
        if ($this->isEnabled()) {
            return $this->_client->syncMObjects($paramsSyncMObjects);
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * deleteCustomObjects
     *
     * Deletes one or more MObjecs and returns the outcome of the operation (DELETED, UNCHANGED, FAILED).
     * Each MOBject must be identified by a Marketo ID or and external-key.
     *
     * @param ParamsDeleteMObjects $paramsDeleteMObjects
     * @return mixed
     * @throws Exception
     */
    public function deleteMObjects(ParamsDeleteMObjects $paramsDeleteMObjects)
    {

        if ($this->isEnabled()) {
            return $this->_client->deleteMObjects($paramsDeleteMObjects);
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * getLead
     *
     * This function retrieves a single lead record from Marketo, with all field values for the built-in and custom fields, for a lead identified by the provided key (LeadKey). If the lead exists based on the input parameters, the lead record attributes will be returned in the result.
     *
     * NOTE: Lead attributes that are of string data type and are empty will not be returned as a part of the response.
     *
     * @param LeadKey $key
     * @return mixed
     * @throws Exception
     */
    public function getLead(LeadKey $key)
    {
        if ($this->isEnabled()) {
            return $this->_client->getLead(new ParamsGetLead($key));
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * getMultipleLeads
     *
     * Like getLead, this operation retrieves lead records from Marketo.  Instead of data for a single lead,
     * this call returns data for a batch of leads which match the criteria passed into the leadSelector
     * parameter. The criteria can be a date range, such as the last updated date; an array of lead keys; or a static list.
     *
     * Note: If you use an array of lead keys, you will be limited to 100 per batch; additional keys will be ignored.
     *
     * If only a subset of the lead fields are required, the includeAttributes parameter should be used to
     * specify the desired fields.
     *
     * Each getMultipleLeads function call will return up to 1000 leads. If you need to retrieve more than 1000
     * leads, the result will return a stream position, which can be used in subsequent calls to retrieve the
     * next batch of 1000 leads. The remaining count in the result tells you exactly how many leads remain.  When
     * fetching from a static list, the terminating condition is remainingCount == 0.
     *
     * @param ParamsGetMultipleLeads $paramsGetMultipleLeads
     * @return mixed
     * @throws Exception
     */
    function getMultipleLeads(ParamsGetMultipleLeads $paramsGetMultipleLeads)
    {
        if ($this->isEnabled()) {
            $this->_client->__setSoapHeaders($this->_getAuthenticationHeader());
            return $this->_client->getMultipleLeads($paramsGetMultipleLeads);
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * syncLead
     *
     * This function will insert or update a single lead record.  When updating an existing lead, the lead can be
     * identified with one of the following keys:
     *
     * • Marketo ID
     * • Foreign system ID
     * • Marketo Cookie (created by Munchkin JS script)
     * • Email
     *
     * If an existing match is found, the call will perform an update.  If not, it will insert and create a new lead.
     * Anonymous leads can be updated using the Marketo Cookie ID.
     *
     * Except for Email, all of these identifiers are treated as unique keys.  The Marketo ID takes precedence over all
     * other keys.  If both ForeignSysPersonId and the Marketo ID are present in the lead record, then the Marketo ID
     * will take precedence and the ForeignSysPersonId will be updated for that lead.  If the only ForeignSysPersonId is
     * given, then it will be used as a unique identifier.
     *
     * Optionally, a Context Header can be specified to name the target workspace.
     *
     * When Marketo workspaces are enabled and the header is used, the following rules are applied:
     *
     * • New leads are created in the primary partition of the named workspace
     * • Leads matched by the Marketo Lead ID, a foreign system ID, or a Marketo Cookie, must exist in the primary
     *   partition of the named workspace, otherwise an error will be returned
     * • If an existing lead is matched by email, the named workspace is ignored and the lead is updated in its’ current
     *   partition
     *
     * When Marketo workspaces are enabled and the header is NOT used, the following rules are applied:
     *
     * • New leads are created in the primary partition of the “Default” workspace
     * • Existing leads are updated in their current partition
     *
     * If Marketo workspaces are NOT enabled, the target workspace MUST be the “Default” workspace.  It is not necessary
     * to pass the header.
     *
     * @param ParamsSyncLead $paramsSyncLead
     * @return mixed
     * @throws Exception
     */
    function syncLead(ParamsSyncLead $paramsSyncLead)
    {
        if ($this->isEnabled()) {
            return $this->_client->syncLead($paramsSyncLead);
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * syncMultipleLeads
     *
     * This function requests an insert or update (upsert) operation for multiple lead records. When updating an
     * existing lead, the lead can be identified with one of the following keys:
     *
     * Marketo ID
     * Foreign system ID
     * Email
     *
     * If more than one key is present the Marketo ID takes precedence over ForeignSysPersonId, and the latter will be
     * updated. However, if Email is also present as a key, it will not be updated unless it is specified in the list
     * of attributes.
     *
     * You are able to turn off the de-duplication feature with this function call. If dedupEnabled is set to true and
     * no other unique identifier is given (foreignSysPersonId or Marketo lead ID), then the lead record will be
     * de-duplicated using the email address. Keep in mind, passing in false will create duplicates within Marketo.
     *
     * @param ParamsSyncMultipleLeads $paramsSyncMultipleLeads
     * @return mixed
     * @throws Exception
     */
    function syncMultipleLeads(ParamsSyncMultipleLeads $paramsSyncMultipleLeads)
    {
        if ($this->isEnabled()) {
            try {
                $result = $this->_client->syncMultipleLeads($paramsSyncMultipleLeads);
                return $result;
            } catch (Exception $ex) {
                $this->logException($ex);
                return false;
            }
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * mergeLeads
     *
     * Accepts a winning lead's key and multiple losing lead's keys to perform a merge operation.  Returns the ID of the
     * leads and status.
     *
     * @param ParamsMergeLeads $paramsMergeLeads
     * @return mixed
     * @throws Exception
     */
    function mergeLeads(ParamsMergeLeads $paramsMergeLeads)
    {
        if ($this->isEnabled()) {
            return $this->_client->mergeLeads($paramsMergeLeads);
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * getLeadActivity
     *
     * This function retrieves the activity history for a single lead identified by the provided key. You can specify
     * which activity types you wish to be returned in the result. If you want all activity types, a blank value needs
     * to be passed. For more than one activity type, pass in a list of activity types.  When requesting multiple
     * activities, the remaining count is not an accurate number, but should be treated as a flag which indicates that
     * there are more activities when the remaining count > 0.
     *
     * A stream position can be used to paginate through large result sets.
     * The complete list of activity types can be found within the ActivityType enumeration located in the SOAP API WSDL.
     *
     * @param ParamsGetLeadActivity $paramsGetLeadActivity
     * @return SuccessGetLeadActivity
     * @throws Exception
     */
    function getLeadActivity(ParamsGetLeadActivity $paramsGetLeadActivity)
    {
        if ($this->isEnabled()) {
            return $this->_client->getLeadActivity($paramsGetLeadActivity);
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * getLeadChanges
     *
     * This API is just like getLeadActivity except that it operates on multiple leads at once.  The operation checks
     * for new leads created, lead field updates and other activities.
     *
     * The result contains activities that caused the change along with a stream position to paginate through large
     * result sets.
     *
     * You must include an input parameter identifying which activity types you wish to be returned in the result. If
     * you want all activity types, a blank value may be passed. For more than one activity type, pass in a list of
     * activity types. The complete list of activity types can be found in the API WSDL.
     *
     * Some example activity types are: 'VisitWebPage', 'FillOutForm', and 'ClickLink'.
     *
     * After SOAP API version 2_2 you can include a leadSelector.
     *
     * For LastUpdateAtSelector, the oldestUpdatedAt value would correspond to the oldestCreatedAt value in the
     * startPosition. And the latestUpdatedAt value would corresponds to the latestCreatedAt value in the startPosition.
     *
     * Note: The limit number of leads supported in a StaticListSelector and LeadKeySelector is 100. If the number of
     * leads exceeds 100, the API will throw a bad parameter exception and return a SOAP fault.
     *
     * @param ParamsGetLeadChanges $paramsGetLeadChanges
     * @return SuccessGetLeadChanges
     * @throws Exception
     */
    function getLeadChanges(ParamsGetLeadChanges $paramsGetLeadChanges)
    {
        if ($this->isEnabled()) {
            $this->_client->__setSoapHeaders($this->_getAuthenticationHeader());
            return $this->_client->getLeadChanges($paramsGetLeadChanges);
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }

    /**
     * Utilize the Marketo API for to update the known fields available to be mapped between Marketo and SugarCRM.
     *
     * @return array
     * @throws Exception
     */
    public function getSchema($object_name = self::LEAD_RECORD)
    {
        if ($this->isEnabled()) {
            switch ($object_name) {
                case self::LEAD_RECORD:
                    $baseDirectory = 'modules/Connectors/connectors/sources/ext/soap/marketo/';
                    $connector = "ext_soap_marketo";
                    break;
                case self::OPPORTUNITY:
                    $baseDirectory = 'modules/Connectors/connectors/sources/ext/soap/marketo/opportunity/';
                    $connector = "ext_soap_marketo_opportunity";
                    break;
                case self::OPPORTUNITY_PERSON_ROLE:
                    $baseDirectory = 'modules/Connectors/connectors/sources/ext/soap/marketo/role/';
                    $connector = "ext_soap_marketo_role";
                    break;
                default:
                    throw new Exception("Invalid Object Name $object_name provided to function ext_soap_marketo::getSchema");
            }

 //           $dir = create_custom_directory($baseDirectory);
 //           create_custom_directory($baseDirectory . 'language/');

            $lang = ConnectorUtils::getConnectorStrings($connector);
            $success = $this->describeMObject($object_name);

            $this->_field_defs = array();
            foreach ($success->result->metadata->fieldList->field as $field) {
                if (stripos($field->name, "sap_crm") === 0 || stripos($field->name, "microsoft") === 0 || stripos(
                        $field->name,
                        "marketo jigsaw"
                    ) === 0
                ) {
                    continue;
                }

                $object = array(
                    'name' => strtolower($field->name),
                    'marketo' => $field->name,
                    'vname' => strtoupper('LBL_' . $field->name),
                    'type' => $field->dataType,
                    'displayName' => $field->displayName,
                    'description' => $field->description,
                    'sourceObject' => $field->sourceObject,
                    'size' => $field->size,
                    'isReadonly' => $field->isReadonly,
                    'isUpdateBlocked' => $field->isUpdateBlocked,
                    'isName' => $field->isName,
                    'isPrimaryKey' => $field->isPrimaryKey,
                    'isCustom' => $field->isCustom,
                    'isDynamic' => $field->isDynamic,
                    'dynamicFieldRef' => $field->dynamicFieldRef,
                    'updatedAt' => $field->updatedAt,
                );

                $lang[$object['vname']] = $field->displayName;

                switch ($field->dataType) {
                    case 'integer':
                        $object['type'] = 'int';
                        break;
                    case 'string':
                        $object['type'] = 'varchar';
                        break;
                }

                $this->_field_defs[strtolower($field->name)] = $object;
            }

            $header = "<?php\n\nif(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');\n\n";

            $vardefs = array(
                'comment' => 'vardefs for marketo connector',
                'fields' => $this->_field_defs,
            );

            /* MARKETO v1.1.1  eliminate the write_array_to_file */
            require_once('modules/ModuleBuilder/MB/MBVardefs.php');
            $mb = new MBVardefs($connector, null, null);
            $mb->vardefs = $vardefs;
            $mb->build("custom/{$baseDirectory}");

            ConnectorUtils::setConnectorStrings($connector, $lang, 'en_us');

            return $this->_field_defs;
        }

        throw new Exception(self::SERVICE_NOT_ENABLED);
    }


    function logException(Exception $ex, $otherInformation = "")
    {
        $error = array(
            'Message' => $ex->getMessage(),
            'Code' => $ex->getCode(),
            'File' => $ex->getFile(),
            'Line' => $ex->getLine(),
        );

        if (get_class($ex) == "SoapFault") {
            if (isset($ex->detail)) {
                $details = $ex->detail->serviceException;
                if (is_object($details)) {
                    $error['Message'] = $details->message;
                    $error['Code'] = $details->code;
                }
            }
        }

        if ($error['Code'] == '20103') {
//            SugarApplication::appendErrorMessage("This record has been <strong>deleted</strong> from Marketo");
        }
        $GLOBALS['log']->fatal("$otherInformation " . print_r($error, true));

        return false;
    }

    /**
     * getList
     * This is the marketo implementation of the getList method
     *
     * @param $args Array of input/search parameters
     * @param $module String value of the module we are mapping input arguments from
     * @return $result Array of results based on the search results from the given arguments
     */
    public function getList($args = array(), $module = null)
    {
        return array();
    }

    /**
     * getItem
     * This is the marketo implementation of the getItem method
     *
     * @param $args Array of input/search parameters
     * @param $module String value of the module we are mapping input arguments from
     * @return $result Array of result based on the search results from the given arguments
     */
    public function getItem($args = array(), $module = null)
    {
        return array();
    }

    /**
     * Returns marketo synchronization parameters.
     * In 3.3.1 and above there was an error with setting parameters in oracle because platform was not set.
     * So first of all we check 'base' platform and then check null platform to support old settings in mysql
     *
     * @param string $groupName
     * @return array
     */
    protected function getSynchronizationParams($groupName)
    {
        $administration = BeanFactory::getBean('Administration');
        $settings = $administration->getConfigForModule($groupName, 'base', true);
        if ($settings) {
            return $settings;
        }

        return $administration->getConfigForModule($groupName, null, true);
    }

    /**
     * pollMarketoForLeadChanges
     *
     * Used by the Check Marketo for Lead changes Scheduler to download all updates from Marketo
     */
    function pollMarketoForLeadChanges()
    {
        global $timedate;
        $timedate->allow_cache = false;
        $newLeadsCreated = array();

        $max = $this->getProperty('maximum_download');
        // take default rows from sugarConfig

        $config = SugarConfig::getInstance()->get('marketo');

        if (!empty($config['leads_download']['max_rows'])) {
            $max = $config['leads_download']['max_rows'];
        }

        if (empty($max)) {
            $max = 'unlimited';
        }
        // We only want to ask Marketo For Fields that we have mapped to SugarCRM
        $fieldDefs = $this->getFieldDefs();
        foreach ($this->getMapping() as $bean) {
            foreach ($bean as $module) {
                foreach ($module as $mkto => $sugar) {
                    if (!empty($fieldDefs[$mkto]['marketo'])) {
                        $fieldList[] = $fieldDefs[$mkto]['marketo'];
                    }
                }
            }
        }

        // include the field we use for deleting from Marketo
        $fieldList[] = 'sugarcrm_deleted';

        $fieldList[] = 'sugarcrm_id';
        $fieldList[] = 'sugarcrm_type';

        asort($fieldList);
        $fieldList = array_values(array_unique($fieldList));

        $recordsProcessed = 0;
        $doPage = true;
        while ($doPage) {
            $settings = $this->getSynchronizationParams('marketo');
            $wayWayBack = new DateTime('01-01-2000');
            $lastUpdateAtSelect = new LastUpdateAtSelector((empty($settings['oldestUpdatedAt'])) ? $wayWayBack->format(
                DateTime::W3C
            ) : $settings['oldestUpdatedAt']);
            $streamPosition = (empty($settings['streamPosition'])) ? null : $settings['streamPosition'];

            $resultGetMultipleLeads = $this->getMultipleLeads(
                new ParamsGetMultipleLeads($lastUpdateAtSelect, null, $streamPosition, $max, ArrayOfString::withStringItem($fieldList))
            );

            if ($resultGetMultipleLeads->result->remainingCount == 0) {
                $doPage = false;
            }

            if ($resultGetMultipleLeads->result->returnCount == 1) {
                $resultGetMultipleLeads->result->leadRecordList->leadRecord = array($resultGetMultipleLeads->result->leadRecordList->leadRecord);
            }

            if (self::CONSOLE_DEBUG) {
                printf("\npollMarketoForLeadChanges:   Return Count: %3d : Remaining Count: %3d\n",
                    $resultGetMultipleLeads->result->returnCount,
                    $resultGetMultipleLeads->result->remainingCount
                );
            }

            if ($resultGetMultipleLeads->result->returnCount > 0) {
                $count = $resultGetMultipleLeads->result->returnCount;

                foreach ($resultGetMultipleLeads->result->leadRecordList->leadRecord as $leadRecord) {

                    if (self::CONSOLE_DEBUG) {
                        printf("\n-------- MARKETO LEAD Change to SUGAR -------------------------------------------\n");
                        printf("***  Market Lead Being Synced to SUGAR:  Marketo ID: %s  Email: %s ***\n",
                            $leadRecord->Id, $leadRecord->Email);
                        if (!empty($leadRecord->leadAttributeList)) {
                            $attributes = $this->getLeadAttributeList($leadRecord);
                            foreach ($attributes AS $attribute) {
                                printf("  ==> Attrtibute Name:%-28s  Value: %s\n",
                                    $attribute->attrName, $attribute->attrValue);
                            }
                        }
                        printf("-----------------------------------------------------------------------------------\n");
                    }


                    if (count($newLeadsCreated) == 100) {
                        $this->addActivityLogScheduler($newLeadsCreated);
                        $newLeadsCreated = array();
                    }
                    $recordsProcessed++;

                    $bean = $this->getSugarBean($leadRecord);
                    $newBean = (empty($bean->id)) ? true : false;

                    $processBean = true;
                    //if this is a newBean, then we want to check to see if the bean has been deleted from marketo
                    if ($newBean) {
                        $attributes = $this->getLeadAttributeList($leadRecord);
                        foreach ($attributes AS $attribute) {
                            if ($attribute->attrName == 'sugarcrm_deleted' && $attribute->attrValue == '1') {
                                $processBean = false;
                            }
                        }
                    }

                    if ($processBean) {
                        //if this is not a newBean (aka existingBean) then we want to update the data
                        $this->synchronizeMarketoToSugarCRM($leadRecord, $bean, (!$newBean));
                        if ($newBean) {
                            $newLeadsCreated[] = $bean->mkto_id;
                        }
                    }

                    //clean up memory
                    unset($bean);
                    unset($leadRecord);

                    $count--;
                    $GLOBALS['log']->info("COUNT REMAINING-> $count |  TOTAL COUNT -> " . $recordsProcessed);
                }
            } else {
                $doPage = false;
            }

            // Limit the number of records that can be downloaded per pull
            if ($doPage && $max != "unlimited" && $recordsProcessed >= $max) {
                $doPage = false;
            }

            // if we are using 85% of the available memory then we want to wait until the next run
            if ($doPage && $this->getBytes(ini_get('memory_limit')) > 0 && memory_get_peak_usage(
                    true
                ) >= ($this->getBytes(ini_get('memory_limit')) * .85)
            ) {
                $doPage = false;
            }

            $administration = BeanFactory::getBean('Administration');
            $administration->saveSetting(
                'marketo',
                'remainingCount',
                $resultGetMultipleLeads->result->remainingCount,
                'base'
            );
            $administration->saveSetting(
                'marketo',
                'streamPosition',
                ($resultGetMultipleLeads->result->remainingCount > 0) ?
                    $resultGetMultipleLeads->result->newStreamPosition : '',
                'base'
            );
            $administration->saveSetting('marketo', 'last successful sync', $timedate->nowDb(), 'base');

            if ($resultGetMultipleLeads->result->remainingCount > 0) {
                $administration->saveSetting(
                    'marketo',
                    'streamPosition',
                    $resultGetMultipleLeads->result->newStreamPosition,
                    'base'
                );
                $administration->saveSetting('marketo',
                    'oldestUpdatedAt',
                    $lastUpdateAtSelect->oldestUpdatedAt,
                    'base'
                );
            } else {
                $administration->saveSetting('marketo', 'streamPosition', null, 'base');

                // calculate oldestUpdatedAt
                $tl = strpos($resultGetMultipleLeads->result->newStreamPosition, ":tl:") + 4;
                $os = strpos($resultGetMultipleLeads->result->newStreamPosition, ":os:");
                $epoch = substr($resultGetMultipleLeads->result->newStreamPosition, $tl, $os - $tl);
                $oldestUpdatedAt = new DateTime("@$epoch");
                $administration->saveSetting('marketo',
                    'oldestUpdatedAt',
                    $oldestUpdatedAt->format(DateTime::W3C),
                    'base'
                );
            }

            unset($resultGetMultipleLeads);

        }

        if (count($newLeadsCreated) > 0) {
            $this->addActivityLogScheduler($newLeadsCreated);
        }

        //Functionality will be present in MarketoSprint3
        return true;
    }

    /* Only show Opportunities, Contacts, Leads, Accounts & Users */
    public function filterAllowedModules($moduleList)
    {
        $outModuleList = array();
        foreach ($moduleList as $module) {
            if (!in_array($module, $this->allowedModuleList)) {
                continue;
            } else {
                $outModuleList[$module] = $module;
            }
        }
        return $outModuleList;
    }

    /**
     * addMarketoUpdateScheduler
     *
     * This function will added a scheduler job if there are items to push to the Marketo Queue
     */
    public function addMarketoUpdateScheduler()
    {
        global $current_user;

        $db = DBManagerFactory::getInstance('mkto');

        $sql = "select count(*) as count from mkto_queue where mkto_queue.deleted = 0 AND mkto_queue.action in ('POST', 'PUT') AND mkto_queue.bean_module in ('Leads', 'Contacts')";
        $results = $db->query($sql);
        $row = $db->fetchRow($results);

        if ($row['count'] > 0) {

            // if job is already queued don't queue again
            $job = BeanFactory::getBean('SchedulersJobs');
            $res = $db->query(
                "SELECT count(*) as count FROM {$job->table_name} WHERE name = 'MarketoUpdater' AND deleted = 0 AND status in ('queued', 'running')"
            );
            $jobCount = $db->fetchByAssoc($res);
            if ($jobCount['count'] == 0) {

                $job->name = "MarketoUpdater";
                $job->assigned_user_id = $current_user->id;
                $job->target = "class::SugarJobUpdateMarketo";
                $job->retry_count = 5;
                $job->requeue = true;

                // push into the queue to run
                $jq = new SugarJobQueue();
                $jq->submitJob($job);
            }
        }
    }

    private function addActivityLogScheduler(array $data)
    {
        global $current_user;
        $job = BeanFactory::getBean('SchedulersJobs');
        $job->name = "Marketo New Leads Activity Logs";
        $job->assigned_user_id = $current_user->id;

        $job->target = "class::SugarJobGetMarketoActivities";
        $job->retry_count = 5;
        $job->requeue = true;

        $job->data = base64_encode(serialize($data));

        // push into the queue to run
        $jq = new SugarJobQueue();
        $jq->submitJob($job);
    }

    /**
     * Only allow the initial import of Leads that have a score that is greater than the setting
     * for download_score.
     *
     * @param $item
     * @return bool
     */
    public function isLeadAboveImportThreshold(LeadRecord $leadRecord)
    {
        if (empty($this->download_score) || $this->download_score == 0) {
            return true;
        }

        $attributes = $this->getLeadAttributeList($leadRecord);
        foreach($attributes AS $attribute) {
            if ($attribute->attrName == 'LeadScore') {
                if ($attribute->attrValue >= $this->download_score) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return false;
    }

    /**
     * getLeadViaAPI
     *
     * Method to download a Lead from Marketo that is accessed via the API
     *
     * @param LeadKey $leadKey
     * @return LeadRecord
     */
    public function getLeadViaAPI(LeadKey $leadKey)
    {
        if ($this->isEnabled()) {
            $marketoLead = $this->getLead($leadKey);
            $marketoLead = $marketoLead->result->leadRecordList->leadRecord;
            $bean = $this->getSugarBean($marketoLead);

            $this->synchronizeMarketoToSugarCRM($marketoLead, $bean, true);

            return $this->convertLeadAttributesIntoArray($marketoLead, $bean);
        }
    }

    /**
     * downloadSingleMarketoLeadAndSynchronizeWithSugarCRM
     *
     * Given a LeadKey download a single Lead from Marketo and synchronize with SugarCRM
     *
     * @param LeadKey $leadKey
     * @param bool $forceImport
     * @return SugarBean
     * @throws Exception
     */
    public function downloadSingleMarketoLeadAndSynchronizeWithSugarCRM(LeadKey $leadKey, $forceImport = false)
    {
        if ($this->isEnabled()) {
            $marketoLead = $this->getLead($leadKey);
            $marketoLead = $marketoLead->result->leadRecordList->leadRecord;
            $bean = $this->getSugarBean($marketoLead);

            return $this->synchronizeMarketoToSugarCRM($marketoLead, $bean, $forceImport);
        }
    }

    /**
     * getSugarBean
     *
     * We need to find the matching SugarCRM Contact or Lead record
     * Contacts should be found before the Lead is found.
     * If neither a Contact nor a Lead are found create a Lead
     * 1 Check to see if the Marketo ForeignSysPersonId is set (this is the SugarCRM ID)
     * 2.Check to see if the is a Record inside of SugarCRM that has the Marketo Lead ID
     * 3. Check to see if there is a Lead Record inside of SugarCRM that has the email address
     *
     * @param LeadRecord $leadRecord
     */
    public function getSugarBean(LeadRecord $leadRecord)
    {
        global $beanList;

        $bean = null;
        $bean_type = "Leads";
        $bean_id = "";

        // if the lead in marketo is tied to a particular record in Sugar, we want to return that record

        $attributes = $this->getLeadAttributeList($leadRecord);
        foreach($attributes AS $attribute) {
            switch ($attribute->attrName) {
                case 'sugarcrm_id':
                    $bean_id = $attribute->attrValue;
                    break;
                case 'sugarcrm_type':
                    $sugarcrmType = $attribute->attrValue ? ucfirst(strtolower($attribute->attrValue)) : '';
                    if (!empty($sugarcrmType) && array_key_exists($sugarcrmType, $beanList)) {
                        $bean_type = $sugarcrmType;
                    }
                    break;
            }
        }

        if (!empty($bean_id) && !empty($bean_type) && in_array($bean_type, array('Leads', 'Contacts'))) {
            $bean = BeanFactory::getBean($bean_type, $bean_id, array('disable_row_level_security' => true));
            if (!empty($bean->id)) {
                return $bean;
            }
        }
        $GLOBALS['log']->debug("ext_soap_marketo::getSugarBean FIND CONTACT");
        // Find a Contact with the MKTO ID
        $bean = BeanFactory::getBean('Contacts', null, array('disable_row_level_security' => true));
        $bean->retrieve_by_string_fields(array('mkto_id' => $leadRecord->Id));

        if (!empty($bean->id)) {
            return $bean;
        } else {
            $GLOBALS['log']->debug("ext_soap_marketo::getSugarBean FIND LEAD");

            //Find a Lead with the MKTO ID
            $bean = BeanFactory::getBean('Leads', null, array('disable_row_level_security' => true));
            $bean->retrieve_by_string_fields(array('mkto_id' => $leadRecord->Id));

            if (!empty($bean->id)) {
                return $bean;
            } else {
                $GLOBALS['log']->debug("ext_soap_marketo::getSugarBean FIND BY EMAIL");

                // Search for a Contact or Lead by Email Address
                $emailAddress = BeanFactory::getBean('EmailAddresses');
                $results = $emailAddress->getBeansByEmailAddress($GLOBALS['db']->quote($leadRecord->Email));
                if (!empty($results)) {
                    foreach ($results as $ix => $resultBean) {
                        $GLOBALS['log']->debug("emailsBean row $ix has bean id of {$resultBean->id} and mkto_id of {$resultBean->mkto_id}");

                        //If the bean returned from the SugarEmailAddress doesn't have an ID then it is
                        //not a real bean. So we will skip it
                        if (!empty($resultBean->mkto_id)) {
                            $GLOBALS['log']->fatal("An object with email " . $leadRecord->Email . " with a different marketo id than " . $resultBean->mkto_id . " already exists");
                            continue;
                        }

                        switch ($resultBean->object_name) {
                            case 'Contact':
                                $GLOBALS['log']->fatal("ext_soap_marketo::getSugarBean CONTACT FOUND BY EMAIL {$leadRecord->Email}");
                                return $resultBean;
                            case 'Lead':
                                $GLOBALS['log']->fatal("ext_soap_marketo::getSugarBean LEAD FOUND BY EMAIL {$leadRecord->Email}");
                                return $resultBean;
                        }
                    }
                }
            }
        }

        $GLOBALS['log']->debug("ext_soap_marketo::getSugarBean; SugarBean not found create a new " . $bean_type);

        return BeanFactory::getBean($bean_type, null, array('disable_row_level_security' => true));
    }

    protected function convertLeadAttributesIntoArray(LeadRecord $leadRecord, SugarBean $bean = null)
    {
        global $timedate;
        $results =
            array(
                'id' => $leadRecord->Id,
                'email' => $leadRecord->Email,
            );

        $attributes = $this->getLeadAttributeList($leadRecord);
        foreach($attributes AS $attribute) {
            $marketoFieldName = strtolower($attribute->attrName);
            if (!empty($bean->id) && $marketoFieldName === 'leadstatus' && $this->isLeadConverted($bean)) {
                // Lead Status Cannot be altered once the Lead is in 'Converted' status
                continue;
            }
            $results[$marketoFieldName] = MarketoHelper::getFieldValue(
                $bean,
                $attribute->attrName,
                $attribute->attrValue
            );
        }

        return $results;
    }

    public function synchronizeMarketoToSugarCRM(LeadRecord $leadRecord, SugarBean $bean, $forceImport = false)
    {
        global $timedate;
        $GLOBALS['log']->debug(
            "Synchronize DATA from Marketo: ID = $leadRecord->Id | " . ucwords($bean->object_name) . " ID =  $bean->id"
        );

        if (!empty($bean->id) && $bean->module_name === 'Leads' && $this->isLeadConverted($bean)) {
            return false;
        }

        if (self::CONSOLE_DEBUG) {
            printf("\n--- >>> SynchronizeMarketoToSugarCRM:  %5s - %5s - %5s\n",
                $forceImport ? "true" : "false",
                ($bean->mkto_sync && !empty($bean->mkto_id)) ? "true" : "false",
                $this->isLeadAboveImportThreshold($leadRecord) ? "true" : "false"
            );
        }

        if ($forceImport || ($bean->mkto_sync && !empty($bean->mkto_id)) || $this->isLeadAboveImportThreshold($leadRecord)) {
            $bean->initialMarketoImport = (empty($bean->mkto_id)) ? true : false;

            $currentOptout = false;
            $currentInvalid = false;

            $initialMktoSync = $bean->mkto_sync;
            $initialMktoId   = $bean->mkto_id;

            $mapping = $this->getMapping();
            $values = $this->convertLeadAttributesIntoArray($leadRecord, $bean);

            $newPrimaryEmail = null;
            if (!empty($bean->id)) {
                 $bean->emailAddress->handleLegacyRetrieve($bean);
                 foreach ($bean->emailAddress->addresses as $index => $addressRecord) {
                    if (strtolower($addressRecord['email_address']) == strtolower($leadRecord->Email)) {
                        $currentOptout  = (bool) $addressRecord['opt_out'];
                        $currentInvalid = (bool) $addressRecord['invalid_email'];
                        $newPrimaryEmail = $addressRecord['email_address'];
                        break;
                    }
                 }
                $bean->emailAddress->dontLegacySave = true;
             }

            $isInvalid = false;
            $isOptout  = false;
            $doNotCall = false;

            $fieldDefs = $this->getFieldDefs();
            $bean->downloaded_marketo_data = $values;
            foreach ($mapping['beans'][MarketoHelper::getObjectName($bean)] as $marketo => $sugar) {
                if ($sugar != 'id') {
                    if (isset($values[$marketo])) {
                        if ($marketo == 'unsubscribed') {
                            $isOptout = (bool)$values[$marketo];
                            if (self::CONSOLE_DEBUG) {
                                printf("   ** %s => %s  %0d\n", $marketo, $sugar, (int)$values[$marketo]);
                            }
                        } elseif ($marketo == 'donotcall') {
                            $doNotCall = (bool)$values[$marketo];
                            if (self::CONSOLE_DEBUG) {
                                printf("   ** %s => %s  %0d\n", $marketo, $sugar, (int)$values[$marketo]);
                            }
                        } elseif ($marketo == 'emailinvalid') {
                            $isInvalid = (bool)$values[$marketo];
                            if (self::CONSOLE_DEBUG) {
                                printf("   ** %s => %s  %0d\n", $marketo, $sugar, (int)$values[$marketo]);
                            }
                        }
                        if (self::CONSOLE_DEBUG) {
                            printf(
                                "   ... MAP Marketo Field='%s' Value='%s'   to Sugar Field='%s'\n",
                                $marketo,
                                $values[$marketo],
                                $sugar
                            );
                        }

                        $valueToSet = $values[$marketo];

                        if ($sugar === 'email') {
                            if (empty($bean->id)) {
                                $valueToSet = array(
                                    array('email_address' => $values[$marketo], 'primary_address' => '1')
                                );
                            } elseif ($newPrimaryEmail) {
                                foreach ($bean->emailAddress->addresses as $index => $addressRecord) {
                                    $bean->emailAddress->addresses[$index]['primary_address'] =
                                        ($addressRecord['email_address'] === $newPrimaryEmail) ? '1' : '0';
                                }
                                $valueToSet = $bean->emailAddress->addresses;
                            }
                        }

                        $bean->{$sugar} = $valueToSet;
                    } else {
                        if ($bean->mkto_sync) {
                            if (self::CONSOLE_DEBUG) {
                                printf(
                                    "   ... Set Default: Marketo Field='%s'   to Sugar Field='%s'\n",
                                    $marketo,
                                    $sugar,
                                    $bean->{$sugar}
                                );
                            }
                            $this->setDefaultValue($bean, $marketo, $sugar, $fieldDefs);
                        }
                    }
                }
            }
            if (self::CONSOLE_DEBUG) {
                printf(
                    "\nFrom Marketo: %s -- %s\n   %s %s --  optout=%0d --- invalid=%0d -- DoNotCall=%0d\n",
                    $bean->module_name,
                    $bean->id,
                    $bean->first_name,
                    $bean->last_name,
                    $isOptout,
                    $isInvalid,
                    $doNotCall
                );
            }

            $bean->mkto_sync = true;
            $bean->in_workflow = true;
            $performSave = false;
            $beanSave = false;
            if (empty($bean->id)) {
                $bean->assigned_user_id = $this->getAssignedUserId($bean, $values);

                // make sure that there is not already a Lead with this MKTO_ID
                $beanAlreadyExists = BeanFactory::getBean(
                    MarketoHelper::getObjectName($bean),
                    null,
                    array('disable_row_level_security' => true)
                );
                $beanAlreadyExists->retrieve_by_string_fields(array('mkto_id', $bean->mkto_id));

                if (empty($beanAlreadyExists->id)) {
                    $performSave = true;
                    if (isset($GLOBALS['check_notify'])) {
                        $check_notify = $GLOBALS['check_notify'];
                    } else {
                        $check_notify = false;
                    }

                    if (!$initialMktoSync && empty($initialMktoId)) {
                        // This Bean is new From Marketo and is becoming Syncable for the First Time
                        // Force all of the updated Sugar Data to Sync Back To Marketo
                        $bean->initialMarketoImport=true;
                    }
                    if (self::CONSOLE_DEBUG) {
                        printf(" --------- BEAN SAVE (NEW BEAN:  %s : %s)\n",$bean->module_name, $bean->id);
                    }
                    $bean->marketo = array();
                    $bean->marketo['current_opt_out'] = $currentOptout;
                    $bean->marketo['current_invalid_email'] = $currentInvalid;
                    $bean->marketo['new_opt_out'] = $isOptout;
                    $bean->marketo['new_invalid_email'] = $isInvalid;
                    $bean->save($check_notify);
                }
            } else {

                //if the field sugarcrm_deleted is set then we will delete the record from SugarCRM
                if (isset($values['sugarcrm_deleted']) && intval($values['sugarcrm_deleted']) == 1) {
                    if (!array_key_exists('sugarcrm_id', $values) || $bean->id != $values['sugarcrm_id']) {
                        $GLOBALS['log']->warn('Marketo Sync: Bean ' . $bean->id . ' has deleted flag set in marketo, but bean is associated with id ' . array_key_exists('sugarcrm_id', $values) ? $values['sugarcrm_id'] : ' being empty');
                    }
                    else {
                        $bean->mark_deleted($bean->id);
                        return $bean;
                    }
                }

                // Only Save if the bean has actually changed
                foreach ($bean->field_defs as $field => $value) {
                    if (isset($value['source']) && $value['source'] == 'non-db') {
                        continue;
                    }
                    switch ($value['type']) {
                        case 'link':
                        case 'relate':
                            break;
                        case 'date':
                            if (array_key_exists($field, $bean->fetched_row) &&
                                $bean->$field != $bean->fetched_row[$field]
                            ) {
                                $performSave = true;
                                if (self::CONSOLE_DEBUG) {
                                    printf(
                                        "  *** BEAN FIELD CHANGED [1]: '%s' from(%s) to(%s)\n",
                                        $field,
                                        $bean->fetched_row[$field],
                                        $bean->$field
                                    );
                                }
                                if (self::CONSOLE_DEBUG) {
                                    break; // In Debug Mode - we want to see ALL Field Changes
                                }
                                break 2;
                            }
                            break;
                        case 'datetime':
                            if (array_key_exists($field, $bean->fetched_row) &&
                                $bean->$field != $timedate->to_display_date_time($bean->fetched_row[$field]) &&
                                $bean->$field != $bean->fetched_row[$field]
                            ) {
                                $performSave = true;
                                if (self::CONSOLE_DEBUG) {
                                    printf(
                                        "  *** BEAN FIELD CHANGED [2]: '%s' from(%s) to(%s)\n",
                                        $field,
                                        $timedate->to_display_date_time($bean->fetched_row[$field]),
                                        $bean->$field
                                    );
                                }
                                if (self::CONSOLE_DEBUG) {
                                    break; // In Debug Mode - we want to see ALL Field Changes
                                }
                                break 2;
                            }
                            break;
                        default:
                            switch ($field) {
                                case "name":
                                    break;
                                default:
                                    if (array_key_exists($field, $bean->fetched_row) &&
                                        $bean->$field != $bean->fetched_row[$field]
                                    ) {
                                        $performSave = true;
                                        if (self::CONSOLE_DEBUG) {
                                            printf(
                                                "  *** BEAN FIELD CHANGED [3]: '%s' from(%s) to(%s)\n",
                                                $field,
                                                $bean->fetched_row[$field],
                                                $bean->$field
                                            );
                                        }
                                        if (self::CONSOLE_DEBUG) {
                                            break; // In Debug Mode - we want to see ALL Field Changes
                                        }
                                        break 3;
                                    }
                            }
                    }
                }

                if ((int) $doNotCall != (int) $bean->do_not_call) {
                    if (self::CONSOLE_DEBUG) {
                        printf("  *** BEAN FIELD CHANGED [4]: '%s' from(%s) to(%s)\n",
                            'do_not_call',
                            (int)$bean->do_not_call,
                            (int)$doNotCall
                        );
                    }
                    $bean->do_not_call = (int) $doNotCall;
                    $performSave = true;
                }

                $owner = $this->getAssignedUserId($bean, $values);
                if ($owner != $bean->assigned_user_id) {
                    if (self::CONSOLE_DEBUG) {
                        printf("  *** BEAN FIELD CHANGED [7]: '%s' from(%s) to(%s)\n",
                            'assigned_user_id',
                            $bean->assigned_user_id,
                            $owner
                        );
                    }
                    $bean->assigned_user_id = $owner;
                    $performSave = true;
                }

                if ((bool) $isOptout != (bool) $currentOptout) {
                    if (self::CONSOLE_DEBUG) {
                        printf("  *** BEAN FIELD CHANGED [5]: '%s' from(%s) to(%s)\n",
                            'mrkto2_unsubscribed_c',
                            (int) $currentOptout,
                            (int) $isOptout
                        );
                    }
                    $bean->mrkto2_unsubscribed_c = (bool) $isOptout;
                    $bean->email_opt_out = (bool) $isOptout;
                    $performSave = true;
                }

                if ((bool) $isInvalid != (bool) $currentInvalid) {
                    if (self::CONSOLE_DEBUG) {
                        printf("  *** BEAN FIELD CHANGED [6]: '%s' from(%s) to(%s)\n",
                            'invalid_email',
                            (int) $currentInvalid,
                            (int) $isInvalid
                        );
                    }
                    $bean->invalid_email = (bool) $isInvalid;
                    $performSave = true;
                }

                if ($performSave) {
                    // If we are using the UI then we do not want to update the
                    // Date Modified, Date Entered, or modified_by
                    $bean->update_date_modified = false;
                    $bean->update_date_entered = false;
                    $bean->update_modified_by = false;
                    if (!$initialMktoSync && $bean->mkto_sync && empty($initialMktoId)) {
                        // This Bean is new From Marketo and is becoming Syncable for the First Time
                        // Force all of the updated Sugar Data to Sync Back To Marketo
                        $bean->initialMarketoImport=true;
                    }
                    if (self::CONSOLE_DEBUG) {
                        printf(" --------- BEAN SAVE (EXISTING BEAN:  %s : %s)\n",$bean->module_name, $bean->id);
                    }
                    $bean->marketo = array();
                    $bean->marketo['current_opt_out'] = $currentOptout;
                    $bean->marketo['current_invalid_email'] = $currentInvalid;
                    $bean->marketo['new_opt_out'] = $isOptout;
                    $bean->marketo['new_invalid_email'] = $isInvalid;
                    $beanSave = true;
                }
                MarketoHelper::isUniqueEmail($leadRecord->Email, $bean, true);
            }

            unset($values);
            $bean->emailAddress->regex = "/\w/";

            $beanPrimaryEmail = MarketoHelper::getBeanPrimaryEmail($bean);
            if (strtolower($leadRecord->Email) == strtolower($beanPrimaryEmail)
                && $leadRecord->Email != $beanPrimaryEmail) {
                $performSave = true;
            }


            if (MarketoHelper::isUniqueEmail($leadRecord->Email, $bean)) {
                //set all existing email addresses as non-primary
                foreach ($bean->emailAddress->addresses as $index => $value) {
                    $bean->emailAddress->addresses[$index]['primary_address'] = 0;
                }
                $bean->emailAddress->addAddress(
                    $leadRecord->Email,
                    true,
                    false,
                    $isInvalid,
                    $isOptout
                );
                $bean->emailAddress->save($bean->id, MarketoHelper::getObjectName($bean));
                if (self::CONSOLE_DEBUG) {
                    printf(" --------- BEAN EMAIL ADDRESS SAVE  %s - Invalid:%s - Optout:%s\n",
                        $leadRecord->Email,
                        $isInvalid ? "true" : "false",
                        $isOptout ? "true" : "false"
                    );
                }
            } else {
                if ($performSave) {
                    $bean->emailAddress->AddUpdateEmailAddress(
                        $leadRecord->Email,
                        $isInvalid,
                        $isOptout
                    );
                    if (self::CONSOLE_DEBUG) {
                        printf(
                            " --------- BEAN EMAIL ADDRESS AddUpdateEmailAddress  %s - Invalid:%s - Optout:%s\n",
                            $leadRecord->Email,
                            $isInvalid ? "true" : "false",
                            $isOptout ? "true" : "false"
                        );
                    }
                }
            }


            if ($beanSave) {
                $bean->save(false);
            }

            return $bean;

        }

        return false;
    }

    /**
     * Set the Value of the specified Sugar Bean field to its Default Value.
     * The Default Value is the value that a field takes on when the Field is not passed
     * from Marketo into Sugar ( i.e it's 'Empty' Value )
     *
     * @param SugarBean $bean
     * @param string $marketoFieldName
     * @param string $sugarFieldName
     * @param array $fieldDefs
     */
    protected function setDefaultValue(SugarBean $bean, $marketoFieldName, $sugarFieldName, $fieldDefs)
    {
        if (!empty($fieldDefs[$marketoFieldName]['type'])) {
            switch($fieldDefs[$marketoFieldName]['type']) {
                case 'boolean': {
                    $bean->$sugarFieldName = FALSE;
                    break;
                }
                case 'int': {
                    $bean->$sugarFieldName = 0;
                    break;
                }
                case 'varchar':
                case 'text':
                case 'textarea':
                case 'url':
                case 'email':
                case 'phone': {
                    $bean->$sugarFieldName = '';
                    break;
                }
                case 'float': {
                    $bean->$sugarFieldName = 0.0;
                    break;
                }
                case 'currency' :
                case 'percent': {
                    $bean->$sugarFieldName = 0.0;
                    break;
                }
                case 'date' :
                case 'datetime': {
                    $bean->$sugarFieldName = '';
                    break;
                }
                default: {
                    break;
                }
            }
        }
    }

    /**
     * We allow Marketo users to change the Owner's email address to reset the owner of a record.
     * This function looks for a user in the system that matches the email address provided by Marketo
     * and reassigns the record
     *
     * @param SugarBean $bean
     * @param array $values
     * @return string
     */
    private function getAssignedUserId(SugarBean $bean, array $values)
    {
        $email_address = @$values['sugarcrm_owner_email'];
        if (!empty($email_address)) {
            $owner = BeanFactory::getBean('Users', $bean->assigned_user_id);
            if ($owner->emailAddress->getPrimaryAddress($bean) != $values['sugarcrm_owner_email']) {
                $users = $owner->emailAddress->getRelatedId($values['sugarcrm_owner_email'], 'Users');
                if (count($users) > 0) {
                    return $users[0];
                } else {
                    return $bean->assigned_user_id;
                }
            }
        } else {
            if (empty($bean->id)) {
                return $this->getProperty('assigned_user_id');
            } else {
                return $bean->assigned_user_id;
            }
        }
    }

    public function getMapping()
    {
        $mapping = parent::getMapping();
        if (empty($mapping['beans']['Contacts']) || empty($mapping['beans']['Leads'])) {
            $mapping = parent::getOriginalMapping();
        }

        $mapping['beans']['Contacts']['id'] = "mkto_id";
        $mapping['beans']['Leads']['id'] = "mkto_id";

        return $mapping;
    }

    /**
     * This function will calculate the maximum amount of memory that that can be used by this program. We want to
     * ensure that we don't use more memory than what is allowed
     *
     * @param $val
     * @return int|string
     */
    private function getBytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

    public function getFilters()
    {
        $filters = $this->getProperty('filters');
        $newLeadIncluded = false;
        foreach ($filters as $filter) {
            if ($filter == 'NewLead') {
                $newLeadIncluded = true;
            }
            break;
        }

        if (!$newLeadIncluded) {
            $filters[] = 'NewLead';
        }

        return $filters;
    }

    /**
     * Scheduler to download Activities from Marketo
     *
     * @throws Exception
     */
    public function pollMarketoForLeadActivityChanges()
    {
        global $timedate;

        if ($this->isEnabled()) {
            // take default rows per loop or load from sugarConfig

            $config = SugarConfig::getInstance()->get('marketo');
            $rowsPerLoop = 1000;

            if (!empty($config['activity_sync']['max_rows'])) {
                $rowsPerLoop = $config['activity_sync']['max_rows'];
            }

            $doPage = true;

            while ($doPage) {
                $settings = $this->getSynchronizationParams('marketo_activity_log');
                if (!empty($settings['startPosition'])) {
                    $startPosition = unserialize($settings['startPosition']);
                } else {
                    $startPosition = new StreamPosition();
                    if (!empty($settings['oldestUpdatedAt'])) {
                        $startPosition->oldestCreatedAt = $settings['oldestUpdatedAt'];
                    } else {
                        if (!empty($settings['last successful sync'])) {
                            $dt = new DateTime($settings['last successful sync'], new DateTimeZone('GMT'));
                        } else {
                            $dt = new DateTime('2007-01-01', new DateTimeZone('UTC'));
                        }
                        $startPosition->oldestCreatedAt = $dt->format(DateTime::W3C);
                    }
                }

                $successGetLeadChanges = $this->getLeadChanges(
                    new ParamsGetLeadChanges($startPosition, new ActivityTypeFilter(new ArrayOfActivityType($this->getFilters(
                    ))), $rowsPerLoop)
                );

                if ($successGetLeadChanges->result->remainingCount == 0) {
                    $doPage = false;
                }

                if (self::CONSOLE_DEBUG) {
                    printf("\npollMarketoForLeadActivityChanges:   Return Count: %3d : Remaining Count: %3d\n",
                        $successGetLeadChanges->result->returnCount,
                        $successGetLeadChanges->result->remainingCount
                    );
                }

                if ($successGetLeadChanges->result->returnCount > 0) {
                    if (!is_array($successGetLeadChanges->result->leadChangeRecordList->leadChangeRecord)) {
                        $successGetLeadChanges->result->leadChangeRecordList->leadChangeRecord = array($successGetLeadChanges->result->leadChangeRecordList->leadChangeRecord);
                    }

                    foreach ($successGetLeadChanges->result->leadChangeRecordList->leadChangeRecord as $leadChangeRecord) {
                        $this->synchronizeActivityLogsToSugarCRM($leadChangeRecord);
                    }

                } else {
                    $doPage = false;
                }
                $administration = BeanFactory::getBean('Administration');
                $administration->saveSetting(
                    'marketo_activity_log',
                    'remainingCount',
                    $successGetLeadChanges->result->remainingCount,
                    'base'
                );
                $administration->saveSetting(
                    'marketo_activity_log',
                    'startPosition',
                    ($successGetLeadChanges->result->remainingCount > 0) ? serialize(
                        $successGetLeadChanges->result->newStartPosition
                    ) : '',
                    'base'
                );
                $administration->saveSetting('marketo_activity_log',
                    'last successful sync',
                    $timedate->nowDb(),
                    'base'
                );
                $administration->saveSetting(
                    'marketo_activity_log',
                    'oldestUpdatedAt',
                    $successGetLeadChanges->result->newStartPosition->latestCreatedAt,
                    'base'
                );

                if ($doPage && $this->getBytes(ini_get('memory_limit')) > 0 && memory_get_peak_usage(
                        true
                    ) >= ($this->getBytes(ini_get('memory_limit')) * .85)
                ) {
                    $doPage = false;
                }
            }
        } else {
            throw new Exception(self::SERVICE_NOT_ENABLED);
        }
    }

    public function synchronizeActivityLogsToSugarCRM(LeadChangeRecord $leadChangeRecord)
    {
        $bean = $this->getSugarBean(
            new LeadRecord($leadChangeRecord->mktPersonId, null, null, null, new ArrayOfAttribute(array()))
        );
        if (is_object($bean) && $bean->mkto_id == $leadChangeRecord->mktPersonId) {
            $activityLog = BeanFactory::getBean(
                'ActivityLogs',
                $leadChangeRecord->id,
                array('disable_row_level_security' => true),
                false
            );

            if (empty($activityLog->id)) {
                $activityLog = BeanFactory::getBean('ActivityLogs');
                $activityLog->new_with_id = true;
                $activityLog->id = $leadChangeRecord->id;
            } else {
                if ($activityLog->deleted) {
                    $activityLog->mark_undeleted($leadChangeRecord->id);
                }
            }

            $activityLog->name = $leadChangeRecord->activityType;
            $activityLog->campaign_name = isset($leadChangeRecord->campaign) ? $leadChangeRecord->campaign : "";
            $activityLog->description = $leadChangeRecord->mktgAssetName;
            $activityLog->assigned_user_id = 1;
            $activityLog->team_id = 1;

            $activityDateTime = new DateTime($leadChangeRecord->activityDateTime);
            $activityDateTime->setTimezone(new DateTimeZone('UTC'));

            $activityLog->date_entered = $activityDateTime->format(TimeDate::DB_DATETIME_FORMAT);
            $activityLog->date_modified = $activityLog->date_entered;
            $activityLog->update_date_modified = false;
            $activityLog->mkto_id = $leadChangeRecord->mktPersonId;

            foreach ($leadChangeRecord->activityAttributes->attribute as $attribute) {
                if ($attribute->attrName == 'Old Value' || $attribute->attrName == 'Old Status') {
                    $oldValue = $attribute->attrValue;
                } else {
                    if ($attribute->attrName == 'New Value' || $attribute->attrName == 'New Status' || $attribute->attrName == 'Description') {
                        $newValue = $attribute->attrValue;
                    } else {
                        if ($attribute->attrName == 'Source Type') {
                            $source = $attribute->attrValue;
                        }
                    }
                }
            }

            switch ($leadChangeRecord->activityType) {
                case 'New Lead':
                    $activityLog->description = "Lead Name: \"{$leadChangeRecord->mktgAssetName}\", source: " . $source;
                    $activityLog->update_date_entered = true;

                    // if the date of the New Lead information in Marketo is earlier than what is in SugarCRM
                    // we will set the date_entered to be the date that Lead was captured in Marketo
                    if ($activityDateTime->format(TimeDate::DB_DATETIME_FORMAT) < $bean->date_entered) {
                        $bean->date_entered = $activityDateTime->format(TimeDate::DB_DATETIME_FORMAT);
                        $bean->update_date_modified = false;
                        $bean->update_date_entered = true;
                        $bean->update_modified_by = false;

                        $bean->save(false);
                    }
                    break;
                case 'Change Data Value':
                case 'Change Score':
                    $activityLog->description = "Changed {$leadChangeRecord->mktgAssetName} from \"{$oldValue}\" to \"{$newValue}\"";
                    break;
                case 'Change Status in Progression':
                    $activityLog->description = "{$leadChangeRecord->mktgAssetName} \"{$oldValue}\" => \"{$newValue}\"";
                    break;
                case 'Interesting Moment':
                    $activityLog->description = "{$leadChangeRecord->mktgAssetName}: {$newValue}";
                    break;
            }

            $activityLog->save(false);
        }
    }

    public function isLeadConverted(SugarBean $bean)
    {
        return ($bean->status === 'Converted' || !empty($bean->contact_id) || ($bean->converted));
    }

    public function getLeadAttributeList(LeadRecord $leadRecord)
    {
        if (!empty($leadRecord->leadAttributeList->attribute)) {
            if (count($leadRecord->leadAttributeList->attribute) == 1) {
                return array($leadRecord->leadAttributeList->attribute);
            }
            return $leadRecord->leadAttributeList->attribute;
        }
        return array();
    }

    public function getSugarEmailAddress($email)
    {
        if (empty($email)) {
            return false;
        }

        $sea = BeanFactory::getBean('EmailAddresses');
        $emailAddress = $sea->retrieve_by_string_fields( array('email_address_caps' => trim(strtoupper($email))));

        return $emailAddress;
    }

    public function verifyLeadSync(SugarBean $bean)
    {
        if (empty($bean) || empty($bean->id) || $bean->module_name != 'Leads') {
            return false;
        }

        $beanPrimaryEmail = MarketoHelper::getBeanPrimaryEmail($bean);

        if (intVal($bean->mkto_sync) == 0 || empty($beanPrimaryEmail)) {
            $bean->mkto_sync = false;
            $bean->mkto_id = '';
            return false;
        }

                // Once a lead has been converted to a contact, no further updates are synced as 'Lead'
        if ($this->isLeadConverted($bean)) {
            $bean->mkto_sync = false;
            $bean->mkto_id = '';
            $bean->status = 'Converted';
            $bean->converted = true;
            return false;
        }

        // Once a lead has been converted to a contact, no further updates are synced as 'Lead'
        $email = $beanPrimaryEmail;
        $emailUpper = strtoupper($email);
        $sql = "SELECT email_addresses.id eaid, email_address ema, eabr.email_address_id, eabr.bean_module, eabr.bean_id, contacts.mkto_sync, contacts.mkto_id, contacts.id contact_id from email_addresses
                JOIN email_addr_bean_rel eabr ON eabr.email_address_id = email_addresses.id
                JOIN contacts ON contacts.id = eabr.bean_id
                WHERE eabr.bean_module='Contacts' AND contacts.deleted=0 AND email_addresses.deleted=0 AND eabr.deleted=0
                AND (contacts.mkto_id != 0 OR contacts.mkto_sync != 0)
                AND (email_addresses.email_address='$email' OR email_addresses.email_address_caps='$emailUpper')";
        $result = $GLOBALS['db']->query($sql);
        if ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $bean->mkto_sync = false;
            $bean->mkto_id = '';
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function saveConfig()
    {
        $result = parent::saveConfig();
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        if ($this->isEnabled()) {
            if (SugarConfig::getInstance()->get('marketo_has_mapping', false)) {
                MarketoHelper::activateSchedulers();
            }
        } else {
            MarketoHelper::inactivateSchedulers();
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function saveMappingHook($mapping)
    {
        $result = parent::saveMappingHook($mapping);

        $configurator = new Configurator();
        $configurator->config['marketo_has_mapping'] = true;
        $configurator->handleOverride();

        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        return $result;
    }
}
