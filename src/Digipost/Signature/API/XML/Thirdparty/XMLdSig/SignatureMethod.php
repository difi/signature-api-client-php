<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignatureMethod
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignatureMethodType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="HMACOutputLength" type="{http://www.w3.org/2000/09/xmldsig#}HMACOutputLengthType" minOccurs="0"/>
 *         <any namespace='##other' maxOccurs="unbounded" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="Algorithm" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="SignatureMethod")
 */
class SignatureMethod {

  /**
   * @var array
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<any>")
   */
  protected $content;

  /**
   * @Serializer\XmlAttribute
   */
  protected $algorithm;

  public function __construct($content = NULL, $algorithm = NULL) {
    $this->content = $content;
    $this->algorithm = $algorithm;
    return $this;
  }
}

