<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class XmlConfigurationException extends ConfigurationException {

  public function __construct(string $message = "", \Throwable $previous = NULL) {
    parent::__construct($message, $previous);
  }
}

