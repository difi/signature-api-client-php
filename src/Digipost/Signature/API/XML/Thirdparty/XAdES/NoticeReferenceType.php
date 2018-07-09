<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class NoticeReferenceType
 *
 * <pre>
 * <complexType name="NoticeReferenceType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="Organization" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         <element name="NoticeNumbers" type="{http://uri.etsi.org/01903/v1.3.2#}IntegerListType"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\AccessorOrder("custom", custom={"organization","noticeNumbers"})
 */
class NoticeReferenceType {

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $organization;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\IntegerListType")
   */
  protected $noticeNumbers;

  public function __construct(String $organization = NULL,
                              IntegerListType $noticeNumbers = NULL) {
    $this->organization = $organization;
    $this->noticeNumbers = $noticeNumbers;
    return $this;
  }

  public function getOrganization() {
    return $this->organization;
  }

  public function setOrganization(String $value) {
    $this->organization = $value;
  }

  public function withOrganization(String $value) {
    $this->setOrganization($value);
    return $this;
  }

  public function getNoticeNumbers() {
    return $this->noticeNumbers;
  }

  public function setNoticeNumbers(IntegerListType $value) {
    $this->noticeNumbers = $value;
  }

  public function withNoticeNumbers(IntegerListType $value) {
    $this->setNoticeNumbers($value);
    return $this;
  }
}

