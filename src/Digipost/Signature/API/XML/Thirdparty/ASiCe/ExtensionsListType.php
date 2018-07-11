<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ExtensionsListType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ExtensionsListType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://uri.etsi.org/2918/v1.2.1#}Extension" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\ASiCe
 */
class ExtensionsListType {

  /**
   * @var Extension[] $extensions
   * @Serializer\XmlMap(entry="Extension", inline=true)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension>")
   */
  protected $extensions;

  public function __construct(array $extensions = NULL) {
    $this->extensions = $extensions;
  }

  public function &getExtensions() {
    if ($this->extensions === NULL) {
      $this->extensions = [];
    }
    return $this->extensions;
  }

  public function withExtensions(array $values) {
    $content =& $this->getExtensions();
    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

