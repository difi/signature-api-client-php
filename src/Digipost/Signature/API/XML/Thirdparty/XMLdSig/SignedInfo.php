<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use Digipost\Signature\Client\Core\Internal\XML\Marshalling;

/**
 * Class representing SignedInfo
 */
class SignedInfo extends SignedInfoType
{

  public function marshal() {
    Marshalling::marshal($this, $domResult);
    /** @var \DOMDocument $domResult */
    return $domResult->documentElement;
  }
}

