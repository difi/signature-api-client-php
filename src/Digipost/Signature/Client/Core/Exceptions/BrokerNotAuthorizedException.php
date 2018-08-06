<?php
namespace Digipost\Signature\Client\Core\Exceptions;

use Digipost\Signature\API\XML\XMLError;

class BrokerNotAuthorizedException extends SignatureException {

  public function __construct(XMLError $error) {
    parent::__construct($error->getErrorMessage());
  }
}

