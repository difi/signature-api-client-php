<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class X509Data
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="X509DataType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence maxOccurs="unbounded">
 *         <choice>
 *           <element name="X509IssuerSerial" type="{http://www.w3.org/2000/09/xmldsig#}X509IssuerSerialType"/>
 *           <element name="X509SKI" type="{http://www.w3.org/2001/XMLSchema}base64Binary"/>
 *           <element name="X509SubjectName" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *           <element name="X509Certificate" type="{http://www.w3.org/2001/XMLSchema}base64Binary"/>
 *           <element name="X509CRL" type="{http://www.w3.org/2001/XMLSchema}base64Binary"/>
 *           <any processContents='lax' namespace='##other'/>
 *         </choice>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="X509Data")
 */
class X509Data {

  /**
   * @Serializer\XmlElement(cdata=false, namespace="http://www.w3.org/2000/09/xmldsig#")
   * @Serializer\Type("array<any>")
   */
  protected $x509IssuerSerialsAndX509SKISAndX509SubjectNames;

  public function __construct(array $x509IssuerSerialsAndX509SKISAndX509SubjectNames = NULL) {
    $this->x509IssuerSerialsAndX509SKISAndX509SubjectNames = $x509IssuerSerialsAndX509SKISAndX509SubjectNames;
    return $this;
  }

  public function getX509IssuerSerialsAndX509SKISAndX509SubjectNames() {
    if (($this->x509IssuerSerialsAndX509SKISAndX509SubjectNames === NULL)) {
      $this->x509IssuerSerialsAndX509SKISAndX509SubjectNames = [];
    }
    return $this->x509IssuerSerialsAndX509SKISAndX509SubjectNames;
  }
}

