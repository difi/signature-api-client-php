<?php

namespace Digipost\Signature\Client\Core;

class PAdESReference {

  protected $pAdESUrl;  // String

  public static function of($url) {
    return isset($url) ? new PAdESReference($url) : NULL;
  }

  public function __construct($pAdESUrl) {
    $this->pAdESUrl = $pAdESUrl;
    return $this;
  }

  public function getpAdESUrl() {
    return $this->pAdESUrl;
  }
}

