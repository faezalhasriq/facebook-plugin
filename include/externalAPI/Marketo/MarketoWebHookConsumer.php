<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

require_once('include/externalAPI/Marketo/MarketoFactory.php');

define('HTTP_AUTH_HEADER', 'HTTP_MARKETO_WEBHOOK_AUTH');

global $current_user;

/*
 * This is an unauthenticated end point and needs to move to the new REST API
 * using an OAuth2 Client Credentials Grant once available. For now the marketo
 * system is authenticated using a custom HTTP header Marketo-Webhook-Auth
 * header transporting the Marketo SOAP API encryption key.
 */

// only accept posts
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $GLOBALS['log']->debug("MarketoWebHookConsumer: invalid method " . $_SERVER['REQUEST_METHOD']);
    header('HTTP/1.0 405 Method Not Allowed', true, 405);
    return;
}

// check authentication header, if not set we don't return a www-authenticate
// header as this won't help us any further
if (empty($_SERVER[constant('HTTP_AUTH_HEADER')])) {
    $GLOBALS['log']->security("MarketoWebHookConsumer: missing auth header " . constant('HTTP_AUTH_HEADER'));
    header('HTTP/1.0 401 Unauthorized', true, 401);
    return;
}

$marketo = MarketoFactory::getInstance();

// Marketo needs to be enabled
if (!$marketo->isEnabled()) {
    $GLOBALS['log']->debug("MarketoWebHookConsumer: connector not enabled");
    header('HTTP/1.0 503 Service Unavailable', true, 503);
    return;
}

// Validate our secret
if (!$marketo->isSecretValid($_SERVER[constant('HTTP_AUTH_HEADER')])) {
    $GLOBALS['log']->security("MarketoWebHookConsumer: invalid auth header secret");
    header('HTTP/1.0 401 Unauthorized', true, 401);
    return;
}

try {

    $marketo->init();

    $current_user = new User();
    $current_user->getSystemUser();

    // bail out if no id is present
    if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
        $id = htmlspecialchars_decode($_REQUEST['id'], ENT_QUOTES);
    } else {
        $GLOBALS['log']->warn("MarketoWebHookConsumer: no id request paramater set");
        header('HTTP/1.0 400 Bad Request', true, 400);
        return;
    }

    $data = array('sugarcrm' => array());

    $successGetLead = $marketo->getLead(new LeadKey(LeadKeyRef::IDNUM, $id));
    if ($successGetLead->result->count == 1) {

        $leadRecord = $successGetLead->result->leadRecordList->leadRecord;
        $bean = $marketo->getSugarBean($leadRecord);
        $newBean = (empty($bean->id)) ? true : false;

        $bean = $marketo->synchronizeMarketoToSugarCRM($leadRecord, $bean, (!$newBean));

        $data['id'] = $bean->id;

        foreach ($bean->field_name_map as $key => $value) {
            switch ($value['type']) {
                case 'link':
                    break;
                default:
                    if (isset($bean->$key)) {
                        $data['sugarcrm'][$key] = $bean->$key;
                    }
            }
        }
    }

    // There doesn't seem to be anything in SugarCRM's documentation which
    // explicitly explains to consume the return values. However Marketo
    // has the ability to consume the return JSON using a template to map
    // the values back. Keeping this in our response so far to avoid breaking
    // any implementation relying on this functionality.
    header('Content-Type: application/json');
    echo json_encode($data);

} catch (Exception $e) {
    $GLOBALS['log']->warn("MarketoWebHookConsumer: exception caught " . $e->getMessage());
    header('HTTP/1.0 500 Internal Server Error', true, 500);
    return;
}
