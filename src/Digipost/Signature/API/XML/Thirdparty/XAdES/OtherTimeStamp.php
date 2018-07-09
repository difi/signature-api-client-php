<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod;
use Ds\Map;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class OtherTimeStamp
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="OtherTimeStampType">
 *   <complexContent>
 *     <restriction base="{http://uri.etsi.org/01903/v1.3.2#}GenericTimeStampType">
 *       <sequence>
 *         <element ref="{http://uri.etsi.org/01903/v1.3.2#}ReferenceInfo" maxOccurs="unbounded"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}CanonicalizationMethod" minOccurs="0"/>
 *         <choice>
 *           <element name="EncapsulatedTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}EncapsulatedPKIDataType"/>
 *           <element name="XMLTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}AnyType"/>
 *         </choice>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="OtherTimeStamp")
 */
class OtherTimeStamp extends GenericTimeStampType {

  public function __construct(array $referenceInfos = NULL,
                              array $includes = NULL,
                              CanonicalizationMethod $canonicalizationMethod = NULL,
                              array $encapsulatedTimeStampsAndXMLTimeStamps = NULL,
                              String $id = NULL) {
    parent::__construct($referenceInfos, $includes, $canonicalizationMethod,
                        $encapsulatedTimeStampsAndXMLTimeStamps, $id);
    return $this;
  }
}

