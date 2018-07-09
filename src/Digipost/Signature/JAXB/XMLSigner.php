<?php

namespace Digipost\Signature\JAXB;

use Digipost\Signature\API\XML\XMLSignatureType;
use Digipost\Signature\API\XML\XMLSigningOnBehalfOf;

interface XMLSigner {

  function getSignatureType(): XMLSignatureType;

  function getOnBehalfOf(): XMLSigningOnBehalfOf;
}
