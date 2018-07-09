<?php

namespace Digipost\Signature\Client\Core;

use Digipost\Signature\API\XML\XMLIdentifierInSignedDocuments;
use MyCLabs\Enum\Enum;

/**
 * Class IdentifierInSignedDocuments
 *
 * @package Digipost\Signature\Client\Core
 *
 * @method static IdentifierInSignedDocuments PERSONAL_IDENTIFICATION_NUMBER_AND_NAME
 * @method static IdentifierInSignedDocuments DATE_OF_BIRTH_AND_NAME
 * @method static IdentifierInSignedDocuments NAME
 */
class IdentifierInSignedDocuments extends Enum {
  const PERSONAL_IDENTIFICATION_NUMBER_AND_NAME = XMLIdentifierInSignedDocuments::PERSONAL_IDENTIFICATION_NUMBER_AND_NAME;

  const DATE_OF_BIRTH_AND_NAME = XMLIdentifierInSignedDocuments::DATE_OF_BIRTH_AND_NAME;

  const NAME = XMLIdentifierInSignedDocuments::NAME;

  function getXmlEnumValue() {
    return new XMLIdentifierInSignedDocuments($this->value);
  }
}

