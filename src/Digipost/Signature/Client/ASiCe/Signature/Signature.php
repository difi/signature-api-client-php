<?php

namespace Digipost\Signature\Client\ASiCe\Signature;

use Digipost\Signature\Client\ASiCe\ASiCEAttachable;

/**
 * Class Signature
 *
 * @package Digipost\Signature\Client\ASiCe\Signature
 */
class Signature implements ASiCEAttachable {

  protected $xmlBytes;  // byte[]

  public function __construct($xmlBytes) {
    $this->xmlBytes = $xmlBytes;
    return $this;
  }

  public function getFileName() {
    return "META-INF/signatures.xml";
  }

  public function getBytes() {
    return $this->xmlBytes;
  }

  public function getMimeType() {
    return "application/xml";
  }
}

