<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\API\XML\XMLSignerSpecificUrl;

class RedirectUrl {

  private $signer;

  private $url;

  function __construct(String $signer, String $url) {
    $this->signer = $signer;
    $this->url = $url;
  }

  public static function fromJaxb(XMLSignerSpecificUrl $xmlSignerSpecificUrl) {
    return new RedirectUrl($xmlSignerSpecificUrl->getSigner(), $xmlSignerSpecificUrl->getValue());
  }

  public function getSigner(): String {
    return $this->signer;
  }

  public function getUrl(): String {
    return $this->url;
  }
}
