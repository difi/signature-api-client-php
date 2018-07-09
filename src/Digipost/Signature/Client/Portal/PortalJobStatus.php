<?php

namespace Digipost\Signature\Client\Portal;

use MyCLabs\Enum\Enum;

/**
 * Class PortalJobStatus
 *
 * @package Digipost\Signature\Client\Portal
 *
 * @method static PortalJobStatus IN_PROGRESS
 * @method static PortalJobStatus COMPLETED_SUCCESSFULLY
 * @method static PortalJobStatus FAILED
 * @method static PortalJobStatus NO_CHANGES
 */
class PortalJobStatus extends Enum {

  const IN_PROGRESS = 0;

  const COMPLETED_SUCCESSFULLY = 1;

  const FAILED = 2;

  const NO_CHANGES = 3;
}

