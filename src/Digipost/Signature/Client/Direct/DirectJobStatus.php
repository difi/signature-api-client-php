<?php

namespace Digipost\Signature\Client\Direct;

use MyCLabs\Enum\Enum;

/**
 * Class DirectJobStatus
 *
 * @package Digipost\Signature\Client\Direct
 *
 * @method static DirectJobStatus IN_PROGRESS
 * @method static DirectJobStatus COMPLETED_SUCCESSFULLY
 * @method static DirectJobStatus FAILED
 * @method static DirectJobStatus NO_CHANGES
 */
class DirectJobStatus extends Enum {

  const IN_PROGRESS = 0;

  const COMPLETED_SUCCESSFULLY = 1;

  const FAILED = 2;

  const NO_CHANGES = 3;
}

