<?php
namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;
use MyCLabs\Enum\Enum;

/**
 * Class QualifierType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <simpleType name="QualifierType">
 *   <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *     <enumeration value="OIDAsURI"/>
 *     <enumeration value="OIDAsURN"/>
 *   </restriction>
 * </simpleType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class QualifierType extends Enum {
	const OID_AS_URI = 0;
	const OID_AS_URN = 1;
}
