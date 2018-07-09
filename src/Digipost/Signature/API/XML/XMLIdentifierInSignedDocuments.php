<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;
use MyCLabs\Enum\Enum;


/**
 * Class XMLIdentifierInSignedDocument
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 * <p>
 * <pre>
 * <simpleType name="identifier-in-signed-documents">
 *   <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *     <enumeration value="PERSONAL_IDENTIFICATION_NUMBER_AND_NAME"/>
 *     <enumeration value="DATE_OF_BIRTH_AND_NAME"/>
 *     <enumeration value="NAME"/>
 *   </restriction>
 * </simpleType>
 * </pre>s
 *
 * @package Digipost\Signature\API\XML
 */
class XMLIdentifierInSignedDocuments extends Enum {

  const PERSONAL_IDENTIFICATION_NUMBER_AND_NAME = 'PERSONAL_IDENTIFICATION_NUMBER_AND_NAME';

  const DATE_OF_BIRTH_AND_NAME = 'DATE_OF_BIRTH_AND_NAME';

  const NAME = 'NAME';
}
