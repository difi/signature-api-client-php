<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class RuntimeIOException extends SignatureException {

  function __construct(string $message = "", \Throwable $previous = NULL) {
    parent::__construct($message, $previous);
  }
}

