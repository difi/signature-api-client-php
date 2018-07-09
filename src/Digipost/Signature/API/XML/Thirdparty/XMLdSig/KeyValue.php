<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class KeyValue
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="KeyValueType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}DSAKeyValue"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}RSAKeyValue"/>
 *         <any processContents='lax' namespace='##other'/>
 *       </choice>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="KeyValue")
 */
class KeyValue {

  /**
   * @var array
   * @Serializer\XmlElement(cdata=false, namespace="http://www.w3.org/2000/09/xmldsig#")
   * @Serializer\Type("array<any>")
   */
  protected $content;

  public function __construct(array $content = NULL) {
    $this->content = $content;
    return $this;
  }

  public function getContent() {
    if ($this->content === NULL) {
      $this->content = [];
    }
    return $this->content;
  }
}

