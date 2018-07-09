<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

class AddRequestHeaderFilter implements ClientRequestFilter {

  protected $headerName;  // String

  protected $value;  // String

  function __construct($headerName, $value) {
    $this->headerName = $headerName;
    $this->value = $value;
  }

  public function filter($clientRequestContext) // [ClientRequestContext clientRequestContext]
  {
    $clientRequestContext->getHeaders()->add($this->headerName, $this->value);
  }
}

