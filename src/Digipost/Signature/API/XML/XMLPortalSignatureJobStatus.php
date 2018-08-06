<?php
namespace Digipost\Signature\API\XML;

use MyCLabs\Enum\Enum;

class XMLPortalSignatureJobStatus extends Enum {
	const IN_PROGRESS = 'IN_PROGRESS';
	const COMPLETED_SUCCESSFULLY = 'COMPLETED_SUCCESSFULLY';
	const FAILED = 'FAILED';
}

