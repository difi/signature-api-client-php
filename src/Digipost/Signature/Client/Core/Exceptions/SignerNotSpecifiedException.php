<?php

namespace Digipost\Signature\Client\Core\Exceptions;

class SignerNotSpecifiedException extends SignatureException {

  public static $SIGNER_NOT_SPECIFIED = SignerNotSpecifiedException::class;

  function __construct() {
    parent::__construct("Signer's personal identification number must be specified.");
  }
}
