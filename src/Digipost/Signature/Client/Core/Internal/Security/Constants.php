<?php
namespace Digipost\Signature\Client\Core\Internal\Security;

use SimpleSAML\XMLSec\Constants as XMLSecLibConstants;

class Constants extends XMLSecLibConstants {
  const XADESNS = 'http://uri.etsi.org/01903/v1.3.2#';
  const ASICENS = 'http://uri.etsi.org/2918/v1.2.1#';
  const REF_TYPE_SIGNED_PROPERTIES = 'http://uri.etsi.org/01903#SignedProperties';
}