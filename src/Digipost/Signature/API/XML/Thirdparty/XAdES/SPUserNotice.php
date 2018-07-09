<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SPUserNotice
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SPUserNoticeType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="NoticeRef" type="{http://uri.etsi.org/01903/v1.3.2#}NoticeReferenceType" minOccurs="0"/>
 *         <element name="ExplicitText" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="SPUserNotice")
 * @Serializer\AccessorOrder("custom", custom={"noticeRef","explicitText"})
 */
class SPUserNotice {

  /**
   * @var NoticeReferenceType
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\NoticeReferenceType")
   */
  protected $noticeRef;

  /**
   * @var String
   * @Serializer\XmlElement(cdata=false)
   */
  protected $explicitText;

  public function __construct(NoticeReferenceType $noticeRef = NULL,
                              String $explicitText = NULL) {
    $this->noticeRef = $noticeRef;
    $this->explicitText = $explicitText;
    return $this;
  }

  public function getNoticeRef() {
    return $this->noticeRef;
  }

  public function setNoticeRef(NoticeReferenceType $value) {
    $this->noticeRef = $value;
  }

  public function withNoticeRef(NoticeReferenceType $value) {
    $this->withNoticeRef($value);
    return $this;
  }

  public function getExplicitText() {
    return $this->explicitText;
  }

  public function setExplicitText(String $value) {
    $this->explicitText = $value;
  }

  public function withExplicitText(String $value) {
    $this->withExplicitText($value);
    return $this;
  }
}

