<?php

namespace Digipost\Signature\Client\Core;

class ConfirmationReference {

  protected $url;

  public static function of($url) {
    return isset($url) ? new ConfirmationReference($url) : NULL;
  }

  public function __construct($url) {
    $this->url = $url;
    return $this;
  }

  public function getConfirmationUrl() {
    return $this->url;
  }
}

