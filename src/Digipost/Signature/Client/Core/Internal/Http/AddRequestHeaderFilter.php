<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use Psr\Http\Message\RequestInterface;

class AddRequestHeaderFilter implements ClientRequestFilterInterface {

  protected $headerName;

  protected $value;

  function __construct($headerName, $value) {
    $this->headerName = $headerName;
    $this->value = $value;
  }

  public function filter(RequestInterface $request): RequestInterface {
    return $request->withHeader($this->headerName, $this->value);
  }
}
