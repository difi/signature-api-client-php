<?php
namespace Digipost\Signature\API\XML;

use MyCLabs\Enum\Enum;

/**
 * Class XMLStatusRetrievalMethod
 *
 * @package Digipost\Signature\API\XML
 */
class XMLStatusRetrievalMethod extends Enum {
	const WAIT_FOR_CALLBACK = 'WAIT_FOR_CALLBACK';
	const POLLING = 'POLLING';
}
