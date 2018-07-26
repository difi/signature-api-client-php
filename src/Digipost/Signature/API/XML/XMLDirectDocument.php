<?php

namespace Digipost\Signature\API\XML;

use Digipost\Signature\JAXB\XMLDocument;
use Doctrine\Common\Annotations\Annotation\Required;
use JMS\Serializer\Annotation as Serializer;


/**
 * Class XMLDirectDocument
 *
 * <p>The following schema fragment specifies the expected content contained
 * within this class.
 *
 * ```
 * <complexType name="direct-document">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="title">
 *           <simpleType>
 *             <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *               <minLength value="1"/>
 *               <maxLength value="80"/>
 *             </restriction>
 *           </simpleType>
 *         </element>
 *         <element name="description" minOccurs="0">
 *           <simpleType>
 *             <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *               <maxLength value="220"/>
 *             </restriction>
 *           </simpleType>
 *         </element>
 *       </sequence>
 *       <attribute name="href" use="required">
 *         <simpleType>
 *           <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *             <minLength value="4"/>
 *             <maxLength value="100"/>
 *           </restriction>
 *         </simpleType>
 *       </attribute>
 *       <attribute name="mime" use="required">
 *         <simpleType>
 *           <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *             <minLength value="1"/>
 *             <maxLength value="100"/>
 *           </restriction>
 *         </simpleType>
 *       </attribute>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * ```
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\AccessorOrder("custom", custom={"title", "description"})
 */
class XMLDirectDocument implements XMLDocument {

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlElement()
   */
  protected $title;

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlElement()
   */
  protected $description;

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlAttribute
   */
  protected $href;

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlAttribute
   */
  protected $mime;

  /**
   * Fully-initialising value constructor
   *
   * @param String $title
   * @param String $description
   * @param String $href
   * @param String $mime
   */
  public function __construct(String $title = NULL, String $description = NULL,
                              String $href = NULL, String $mime = NULL) {
    $this->title = $title;
    $this->description = $description;
    $this->href = $href;
    $this->mime = $mime;
  }

  /**
   * @return String
   */
  public function getTitle(): String {
    return $this->title;
  }

  /**
   * @param String $title
   */
  public function setTitle(String $title) {
    $this->title = $title;
  }

  /**
   * @return String
   */
  public function getDescription(): String {
    return $this->description;
  }

  /**
   * @param String $description
   */
  public function setDescription(String $description) {
    $this->description = $description;
  }

  /**
   * @return String
   */
  public function getHref(): String {
    return $this->href;
  }

  /**
   * @param String $href
   */
  public function setHref(String $href) {
    $this->href = $href;
  }

  function getMime(): String {
    return $this->mime;
  }

  public function withTitle(String $title) {
    $this->title = $title;
    return $this;
  }

  public function withHref(String $href) {
    $this->href = $href;
    return $this;
  }

  public function withMime(String $mime) {
    $this->mime = $mime;
    return $this;
  }

  public function withDescription(String $description) {
    $this->description = $description;
    return $this;
  }
}
