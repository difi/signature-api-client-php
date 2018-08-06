<?php
namespace Digipost\Signature\Client\Core\Internal\XML;

use Digipost\Signature\Client\Core\Internal\Security\Constants as C;
use SimpleSAML\XMLSec\Utils\XPath as XMLSecLibXPath;

class XPath extends XMLSecLibXPath {
  /** @inheritdoc */
  public static function getXPath(\DOMDocument $doc) {
    $xp = parent::getXPath($doc);
    $xp->registerNamespace('xades', C::XADESNS);
    $xp->registerNamespace('asic', C::ASICENS);
    return $xp;
  }
}