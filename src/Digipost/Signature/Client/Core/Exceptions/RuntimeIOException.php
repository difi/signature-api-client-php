<?php
namespace Digipost\Signature\Client\Core\Exceptions;

use Throwable;

class RuntimeIOException extends SignatureException {

  function __construct(string $message = "", int $code = 0,
                       Throwable $previous = NULL) {
    
    parent::__construct($message, $code, $previous);
  }
}

