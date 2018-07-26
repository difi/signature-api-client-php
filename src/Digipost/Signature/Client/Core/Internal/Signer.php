<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature as XMLSignature;

class Signer {

  private $context;

  private $xmlSignature;

  function __construct(XMLSignature $xmlSignature) {
    $this->xmlSignature = $xmlSignature;
  }

  public function sign(XMLDigitalSignatureContext $signContext) {
    $this->context = $signContext;

    print "OKAAAY, ready to do some signing! :) ";
  }


}