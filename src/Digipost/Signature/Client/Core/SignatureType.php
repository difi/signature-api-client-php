<?php

namespace Digipost\Signature\Client\Core;

use Digipost\Signature\API\XML\XMLSignatureType;
use Digipost\Signature\Client\Core\Internal\MarshallableEnum;
use MyCLabs\Enum\Enum;

/**
 * Class SignatureType
 *
 * @package Digipost\Signature\Client\Core
 *
 * @method static SignatureType AUTHENTICATED_SIGNATURE
 * @method static SignatureType ADVANCED_SIGNATURE
 */
class SignatureType extends Enum implements MarshallableEnum {

  const AUTHENTICATED_SIGNATURE = XMLSignatureType::AUTHENTICATED_ELECTRONIC_SIGNATURE;

  const ADVANCED_SIGNATURE = XMLSignatureType::ADVANCED_ELECTRONIC_SIGNATURE;

  function getXmlEnumValue() {
    return new XMLSignatureType($this->value);
  }
}
