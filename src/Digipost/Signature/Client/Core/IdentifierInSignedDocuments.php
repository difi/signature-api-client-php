<?php

namespace Digipost\Signature\Client\Core;

use Digipost\Signature\API\XML\XMLIdentifierInSignedDocuments;
use Digipost\Signature\Client\Core\Internal\MarshallableEnum;
use MyCLabs\Enum\Enum;

/**
 * Class IdentifierInSignedDocuments
 *
 * @package Digipost\Signature\Client\Core
 *
 * @method static IdentifierInSignedDocuments PERSONAL_IDENTIFICATION_NUMBER_AND_NAME()  Personal identification number and name.
 * @method static IdentifierInSignedDocuments DATE_OF_BIRTH_AND_NAME()                   Date of birth and name.
 * @method static IdentifierInSignedDocuments NAME()                                     Name
 * @Serializer\Exclude()
 */
class IdentifierInSignedDocuments extends Enum implements MarshallableEnum {

  const PERSONAL_IDENTIFICATION_NUMBER_AND_NAME = XMLIdentifierInSignedDocuments::PERSONAL_IDENTIFICATION_NUMBER_AND_NAME;

  const DATE_OF_BIRTH_AND_NAME = XMLIdentifierInSignedDocuments::DATE_OF_BIRTH_AND_NAME;

  const NAME = XMLIdentifierInSignedDocuments::NAME;

  function getXmlEnumValue() {
    return new XMLIdentifierInSignedDocuments($this->value);
  }
}

