<?php

namespace Digipost\Signature\Client\Core;

use Digipost\Signature\Client\ASiCe\ASiCEAttachable;
use MyCLabs\Enum\Enum;

class Document implements ASiCEAttachable {

  protected $title;

  protected $message;

  protected $fileName;

  protected $document;

  protected $fileType;

  //const FileType_PDF = DocumentFileType::PDF;
  //const FileType_TXT = DocumentFileType::TXT;
  public function __construct(
    String $title,
    String $message = NULL,
    String $fileName = NULL,
    DocumentFileType $fileType = NULL,
    $document = NULL
  ) {
    $this->title = $title;
    $this->message = $message;
    $this->fileName = $fileName;
    $this->fileType = $fileType;
    $this->document = $document;
  }

  public function getFileName() {
    return $this->fileName;
  }

  public function getBytes() {
    return $this->document;
  }

  public function getMimeType() {
    return $this->fileType;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getMessage() {
    return $this->message;
  }
}

/**
 * Class DocumentFileType
 *
 * @package Digipost\Signature\Client\Core
 *
 * @method static DocumentFileType PDF
 * @method static DocumentFileType TXT
 */
class DocumentFileType extends Enum {

  const PDF = "application/pdf";

  const TXT = "text/plain";
  }
