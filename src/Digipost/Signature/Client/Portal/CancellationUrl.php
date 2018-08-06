<?php

namespace Digipost\Signature\Client\Portal;

class CancellationUrl {
  /** @var string */
  protected $url;

  public static function of(String $url) {
    return isset($url) ? new CancellationUrl($url) : NULL;
  }

  public function __construct(String $url) {
    $this->url = $url;
  }

  public function getUrl() {
    return $this->url;
  }
}

