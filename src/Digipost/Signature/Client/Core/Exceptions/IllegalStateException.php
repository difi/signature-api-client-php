<?php

namespace Digipost\Signature\Client\Core\Exceptions;

class IllegalStateException extends \RuntimeException {
  public function __construct(string $message = "", \Throwable $previous = NULL) {
    parent::__construct($message, 0, $previous);
  }
}