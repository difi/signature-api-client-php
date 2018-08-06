<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class InvalidStatusQueryTokenException extends SignatureException {

  public function __construct($url, $errorMessageFromServer) {
    parent::__construct(
      "The token in the url '" . $url . "' was not accepted when querying for status. " .
      $errorMessageFromServer);
  }
}

