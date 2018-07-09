<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class XAdESSignatures
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="XAdESSignaturesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}Signature" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\ASiCe
 *
 * @Serializer\XmlRoot(name="XAdESSignatures", namespace="http://uri.etsi.org/2918/v1.2.1#")
 */
class XAdESSignatures {

  /**
   * @var Signature[] $signatures
   * @Serializer\XmlList(entry="Signature", inline=true, namespace="http://www.w3.org/2000/09/xmldsig#")
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature>")
   */
  protected $signatures;

  /**
   * XAdESSignatures constructor.
   *
   * @param array $signatures
   */
  public function __construct(array $signatures = NULL) {
    $this->signatures = $signatures;
  }

  /**
   * Gets the value of the signatures property.
   *
   * <p>
   * This accessor method returns a reference to the live list,
   * not a snapshot. Therefore any modification you make to the
   * returned list will be present inside the JAXB object.
   * This is why there is not a <CODE>set</CODE> method for the signatures property.
   *
   * <p>
   * For example, to add a new item, do as follows:
   * <pre>
   *    getSignatures().add(newItem);
   * </pre>
   *
   *
   * <p>
   * Objects of the following type(s) are allowed in the list
   * {@link Signature }
   */
  public function &getSignatures() {
    if ($this->signatures == NULL) {
      $this->signatures = [];
    }
    return $this->signatures;
  }

  public function withSignatures(array $values) {
    $content =& $this->getSignatures();
    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}
