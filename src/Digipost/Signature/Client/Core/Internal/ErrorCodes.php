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
 */
class ErrorCodes extends Enum {
	const BROKER_NOT_AUTHORIZED = 0;
	const SIGNING_CEREMONY_NOT_COMPLETED = 1;
	const INVALID_STATUS_QUERY_TOKEN = 2;
}

