<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\OnBehalfOf;
use Digipost\Signature\Client\Core\SignatureType;

interface SignerCustomizations {

  function withSignatureType(SignatureType $type);

  function onBehalfOf(OnBehalfOf $onBehalfOf);
}

