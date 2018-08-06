<?php

namespace Digipost\Signature\Client\Core;

class XAdESReference {

  protected $xAdESUrl;

  public static function of($url) {
    return isset($url) ? new XAdESReference($url) : NULL;
  }

  public function __construct($xAdESUrl) {
    $this->xAdESUrl = $xAdESUrl;
  }

  public function getxAdESUrl() {
    return $this->xAdESUrl;
  }

  public function __toString() {
    return $this->xAdESUrl;
  }
}

