<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

use Ds\Map;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Extension
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ExtensionType">
 *   <complexContent>
 *     <extension base="{http://uri.etsi.org/2918/v1.2.1#}AnyType">
 *       <attribute name="Critical" use="required" type="{http://www.w3.org/2001/XMLSchema}boolean" />
 *     </extension>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\ASiCe
 *
 * @Serializer\XmlRoot(namespace="Extension")
 */
class Extension extends AnyType {

  /**
   * @Serializer\XmlAttribute()
   */
  protected $critical;

  public function __construct(array $content = NULL,
                              bool $critical = NULL) {
    parent::__construct($content);
    $this->critical = $critical;
  }

  public function isCritical() {
    return $this->critical;
  }

  public function setCritical($value) {
    $this->critical = $value;
  }

  public function withCritical($value) {
    $this->setCritical($value);
    return $this;
  }

  public function withContent_Object($values) {
    if ($values !== NULL) {
      foreach ($values as $k => $value) {
        $this->getContent()->put($k, $value);
      }
    }
    return $this;
  }

  public function withContent_Collection($values) {
    if (($values != NULL)) {
      $this->getContent()->putAll($values);
    }
    return $this;
  }
}

