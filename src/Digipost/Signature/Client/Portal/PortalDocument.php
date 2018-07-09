<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\Client\Core\Document;
use Digipost\Signature\Client\Core\DocumentFileType;

class PortalDocument extends Document {

  protected $nonsensitiveTitle;  // String

  function __construct(String $title = NULL,
                       String $nonsensitiveTitle = NULL,
                       String $message = NULL,
                       String $fileName = NULL,
                       DocumentFileType $fileType = NULL,
                       $document =  NULL) {
    parent::__construct($title, $message, $fileName, $fileType, $document);
    $this->nonsensitiveTitle = $nonsensitiveTitle;
    return $this;
  }

  public function getNonsensitiveTitle() {
    return $this->nonsensitiveTitle;
  }

  public static function builder($title, $fileName, $document) {
    return new PortalDocumentBuilder($title, $fileName, $document);
  }
}

class PortalDocumentBuilder {

  private $title;

  private $nonsensitiveTitle;

  private $fileName;

  private $document;

  private $message;

  private $fileType;

  public function __construct(String $title,
                              String $fileName,
                              $document) {
    $this->fileType = DocumentFileType::PDF();
    $this->title = $title;
    $this->fileName = $fileName;
    $this->document = $document;
  }

  public function message(String $message) {
    $this->message = $message;
    return $this;
  }

  public function nonsensitiveTitle(String $nonsensitiveTitle) {
    $this->nonsensitiveTitle = $nonsensitiveTitle;
    return $this;
  }

  public function fileType(DocumentFileType $fileType) {
    $this->fileType = $fileType;
    return $this;
  }

  public function build() {
    return new PortalDocument($this->title,
                              $this->nonsensitiveTitle,
                              $this->message,
                              $this->fileName,
                              $this->fileType,
                              $this->document);
  }
}

