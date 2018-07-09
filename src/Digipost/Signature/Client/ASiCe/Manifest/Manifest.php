<?php

namespace Digipost\Signature\Client\ASiCe\Manifest;

use Digipost\Signature\Client\ASiCe\ASiCEAttachable;

/**
 * Class Manifest
 *
 * @package Digipost\Signature\Client\ASiCe\Manifest
 */
class Manifest implements ASiCEAttachable {

  protected $xmlBytes;

  public function __construct($xmlBytes) {
    $this->xmlBytes = $xmlBytes;
  }

  public function getFileName() {
    return "manifest.xml";
  }

  public function getBytes() {
    return $this->xmlBytes;
  }

  public function getMimeType() {
    return "application/xml";
  }
}

