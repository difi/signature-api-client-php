<?php

namespace Digipost\Signature\Client\Core;

use Digipost\Signature\API\XML\XMLSigningOnBehalfOf;
use MyCLabs\Enum\Enum;

/**
 * Class OnBehalfOf
 *
 * @package Digipost\Signature\Client\Core
 *
 * @method static OnBehalfOf SELF
 * @method static OnBehalfOf OTHER
 */
class OnBehalfOf extends Enum {

  const SELF = XMLSigningOnBehalfOf::SELF;

  const OTHER = XMLSigningOnBehalfOf::OTHER;

  function getXmlEnumValue() {
    return new XMLSigningOnBehalfOf($this->value);
  }
}

