<?php
namespace Digipost\Signature\API\XML;

use MyCLabs\Enum\Enum;

class XMLPortalSignatureJobStatus extends Enum {
	const IN_PROGRESS = 0;
	const COMPLETED_SUCCESSFULLY = 1;
	const FAILED = 2;
}

