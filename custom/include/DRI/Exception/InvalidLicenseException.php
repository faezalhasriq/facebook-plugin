<?php

/**
 * @author Emil Kilhage
 */
class InvalidLicenseException extends \SugarApiException
{
    public $errorLabel = 'invalid_license';
    public $messageLabel = 'ERROR_INVALID_LICENSE';
    public $httpCode = 403;
}
