<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;
use MyCLabs\Enum\Enum;

/**
 * Class XMLSigningOnBehalfOf
 *
 * <p>Java class for signing-on-behalf-of.
 *
 * <p>The following schema fragment specifies the expected content contained
 * within this class.
 * <p>
 * <pre>
 * <simpleType name="signing-on-behalf-of">
 *   <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *     <enumeration value="SELF"/>
 *     <enumeration value="OTHER"/>
 *   </restriction>
 * </simpleType>
 * </pre>
 *
 * @Serializer\Exclude()
 */
class XMLSigningOnBehalfOf extends Enum {
  const SELF = 'SELF';
  const OTHER = 'OTHER';
}
