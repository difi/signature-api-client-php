<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use Ds\Map;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Transforms
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="TransformsType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}Transform" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="Transforms")
 */
class Transforms {

  /**
   * @Serializer\XmlList(entry="Transform", inline=true, skipWhenEmpty=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform>")
   */
  protected $transforms;

  public function __construct(array $transforms = NULL) {
    $this->transforms = $transforms;
    return $this;
  }

  public function &getTransforms() {
    if ($this->transforms === NULL) {
      $this->transforms = [];
    }
    return $this->transforms;
  }

  public function withTransforms(array $values) {
    $content =& $this->getTransforms();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

