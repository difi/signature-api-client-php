<?php
namespace Digipost\Signature\Client\Core\Internal;

use MyCLabs\Enum\Enum;

/**
 * Class ErrorCodes
 *
 * @package Digipost\Signature\Client\Core\Internal
 *
 * @method static ErrorCodes BROKER_NOT_AUTHORIZED
 * @method static ErrorCodes SIGNING_CEREMONY_NOT_COMPLETED
 * @method static ErrorCodes INVALID_STATUS_QUERY_TOKEN
 * @method static ErrorCodes ASICE_VALIDATION_FAILED
 */
class ErrorCodes extends Enum {

  const BROKER_NOT_AUTHORIZED = 'BROKER_NOT_AUTHORIZED';
  const SIGNING_CEREMONY_NOT_COMPLETED = 'SIGNING_CEREMONY_NOT_COMPLETED';
  const INVALID_STATUS_QUERY_TOKEN = 'INVALID_STATUS_QUERY_TOKEN';
  const ASICE_VALIDATION_FAILED = 'ASICE_VALIDATION_FAILED';

  public function sameAs(String $errorCode) {
    return $this->getValue() === $errorCode;
  }
}
