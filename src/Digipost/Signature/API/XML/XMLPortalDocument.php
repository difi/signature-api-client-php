<?php

namespace Digipost\Signature\API\XML;

use Digipost\Signature\JAXB\XMLDocument;
use JMS\Serializer\Annotation as Serializer;

class XMLPortalDocument implements XMLDocument {

  protected $title;

  protected $nonsensitiveTitle;

  protected $description;

  /**
   * @var String
   * @Serializer\Type("string")
   * @Serializer\XmlAttribute()
   */
  protected $href;

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlAttribute()
   */
  protected $mime;

  /**
   * XMLPortalDocument constructor.
   *
   * @param String $title
   * @param String $nonsensitiveTitle
   * @param String $description
   * @param String $href
   * @param String $mime
   */
  public function __construct(String $title = NULL,
                              String $nonsensitiveTitle = NULL,
                              String $description = NULL,
                              String $href = NULL,
                              String $mime = NULL
  ) {
    $this->title = $title;
    $this->nonsensitiveTitle = $nonsensitiveTitle;
    $this->description = $description;
    $this->href = $href;
    $this->mime = $mime;
  }

  public function getTitle(): String {
    return $this->title;
  }

  public function setTitle($value) {
    $this->title = $value;
  }

  public function withTitle($value) {
    $this->title = $value;
    return $this;
  }

  public function getNonsensitiveTitle() {
    return $this->nonsensitiveTitle;
  }

  public function setNonsensitiveTitle($value) {
    $this->nonsensitiveTitle = $value;
  }

  public function withNonsensitiveTitle($value) {
    $this->nonsensitiveTitle = $value;
    return $this;
  }

  public function getDescription(): String {
    return $this->description;
  }

  public function setDescription($value) {
    $this->description = $value;
  }

  public function withDescription($value) {
    $this->description = $value;
    return $this;
  }

  public function getHref(): String {
    return $this->href;
  }

  public function setHref($value) {
    $this->href = $value;
  }

  public function withHref($value) {
    $this->href = $value;
    return $this;
  }

  public function getMime(): String {
    return $this->mime;
  }

  public function setMime($value) {
    $this->mime = $value;
  }

  public function withMime($value) {
    $this->mime = $value;
    return $this;
  }
}

