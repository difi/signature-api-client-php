<?php

namespace Digipost\Signature\Client\Core;

class DeleteDocumentsUrl {

  protected $url;

  public static function of($url) {
    return isset($url) ? new DeleteDocumentsUrl($url) : NULL;
  }

  public function __construct($url) {
    $this->url = $url;
  }

  public function getUrl() {
    return $this->url;
  }
}

