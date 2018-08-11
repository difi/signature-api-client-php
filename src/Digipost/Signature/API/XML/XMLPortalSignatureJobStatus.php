<?php
namespace Digipost\Signature\API\XML;

use MyCLabs\Enum\Enum;

/**
 * Class XMLPortalSignatureJobStatus
 *
 * @package Digipost\Signature\API\XML
 */
class XMLPortalSignatureJobStatus extends Enum {
	const IN_PROGRESS = 'IN_PROGRESS';
	const COMPLETED_SUCCESSFULLY = 'COMPLETED_SUCCESSFULLY';
	const FAILED = 'FAILED';
}

