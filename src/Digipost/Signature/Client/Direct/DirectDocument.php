<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\Client\Core\Document;
use Digipost\Signature\Client\Core\DocumentFileType;

/**
 * Class DirectDocument
 *
 * @package Digipost\Signature\Client\Direct
 */
class DirectDocument extends Document {

  /**
   * DirectDocument constructor.
   *
   * @param String           $title
   * @param String           $message
   * @param String           $fileName
   * @param DocumentFileType $fileType
   * @param                  $document
   */
  public function __construct(String $title = NULL, String $message = NULL,
                              String $fileName = NULL,
                              DocumentFileType $fileType = NULL,
                              $document = NULL) {
    parent::__construct($title, $message, $fileName, $fileType, $document);
  }

  public static function builder(String $title, String $fileName,
                                 $document) {
    return new DirectDocumentBuilder($title, $fileName, $document);
  }
}

/**
 * Class DirectDocumentBuilder
 *
 * @package Digipost\Signature\Client\Direct
 */
class DirectDocumentBuilder {

  private $title;

  private $fileName;

  private $document;

  private $message;

  private $fileType;

  public function __construct(String $title, String $fileName, $document) {
    $this->title = $title;
    $this->fileName = $fileName;
    $this->document = $document;
  }

  public function message(String $message) {
    $this->message = $message;
    return $this;
  }

  public function fileType(DocumentFileType $fileType) {
    $this->fileType = $fileType;
    return $this;
  }

  public function build() {
    return new DirectDocument($this->title, $this->message, $this->fileName,
                              $this->fileType, $this->document);
  }
}