<?php

namespace Digipost\Signature\Client\Core\Internal;

use MyCLabs\Enum\Enum;

/**
 * Class IdentifierType
 *
 * @package Digipost\Signature\Client\Core\Internal
 *
 * @method static IdentifierType PERSONAL_IDENTIFICATION_NUMBER
 * @method static IdentifierType EMAIL
 * @method static IdentifierType MOBILE_NUMBER
 * @method static IdentifierType EMAIL_AND_MOBILE_NUMBER
 */
class IdentifierType extends Enum {

  const PERSONAL_IDENTIFICATION_NUMBER = 0;

  const EMAIL = 1;

  const MOBILE_NUMBER = 2;

  const EMAIL_AND_MOBILE_NUMBER = 3;
}

