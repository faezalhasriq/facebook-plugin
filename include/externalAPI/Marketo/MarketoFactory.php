<?php
/*
* Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
* pursuant to the terms of the End User License Agreement available at
* http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
*/

/**
 * Factory to obtain Marketo Connection
 * @api
 */

require_once('include/externalAPI/Marketo/classes/MarketoError.php');
require_once('include/externalAPI/Marketo/classes/Leads.php');
require_once('include/externalAPI/Marketo/classes/MObjects.php');

class MarketoFactory
{
    const MARKETO = "marketo";
    const OPPORTUNITY = "opportunity";

    private static $instance;

    /**
     * returns a handle to the ext_soap_marketo function,
     * if connect = true, we are ready to communicate with the marketo web-service
     *
     * @param bool $connect
     * @param string $type
     * @return ext_soap_marketo
     */
    public static function getInstance($connect = false, $type = self::MARKETO)
    {
        require_once('modules/Connectors/connectors/sources/ext/soap/marketo/marketo.php');
        require_once('modules/Connectors/connectors/sources/ext/soap/marketo/opportunity/opportunity.php');

        switch ($type) {
            case self::MARKETO:
                self::$instance = new ext_soap_marketo();
                break;
            case self::OPPORTUNITY:
                self::$instance = new ext_soap_marketo_opportunity();
                break;
            default:
                throw new SugarApiExceptionNotFound("$type is not a valid type of marketo connector");
        }

        if ($connect) {
            self::$instance->init();
        }

        return self::$instance;
    }
}
