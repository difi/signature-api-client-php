<?php

namespace Digipost\Signature\API\XML;

use MyCLabs\Enum\Enum;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLSignatureType
 *
 * <p>Java class for signature-type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * <p>
 * <pre>
 * <simpleType name="signature-type">
 *   <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *     <enumeration value="ADVANCED_ELECTRONIC_SIGNATURE"/>
 *     <enumeration value="AUTHENTICATED_ELECTRONIC_SIGNATURE"/>
 *   </restriction>
 * </simpleType>
 * </pre>
 * 
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\Exclude()
 */
class XMLSignatureType extends Enum {

  /**
   * @Serializer\XmlValue()
   */
  protected $value;

  const ADVANCED_ELECTRONIC_SIGNATURE = 'ADVANCED_ELECTRONIC_SIGNATURE';
  const AUTHENTICATED_ELECTRONIC_SIGNATURE = 'AUTHENTICATED_ELECTRONIC_SIGNATURE';
}
