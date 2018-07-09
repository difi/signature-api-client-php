<?php
namespace Digipost\Signature\Client\Core\Exceptions;

use Throwable;

class ConfigurationException extends SignatureException {

  function __construct(string $message = "", Throwable $previous = NULL) {
    $code = 0;
    parent::__construct($message, $code, $previous);
  }
}
