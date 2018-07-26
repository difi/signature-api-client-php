<?php

namespace Digipost\Signature\Client\Core\Internal;

use XmlDsig\XmlDigitalSignature;

class XMLDigitalSignatureContext extends XmlDigitalSignature {

  static $digestUriMapping = [];

  function __construct() {
    //$this->digestMethodUriMapping
    //    self::DIGEST_SHA1		=> 'http://www.w3.org/2000/09/xmldsig#sha1',
    //		self::DIGEST_SHA256		=> 'http://www.w3.org/2001/04/xmlenc#sha256',
    //		self::DIGEST_SHA512		=> 'http://www.w3.org/2001/04/xmlenc#sha512',
    //		self::DIGEST_RIPEMD160	=> 'http://www.w3.org/2001/04/xmlenc#ripemd160',
    $this->createStaticUriMappings();
  }

  private function createStaticUriMappings() {
    foreach ($this->digestMethodUriMapping as $key => $uri) {
      self::$digestUriMapping[$key] = $uri;
    }
  }

  public static function getDigestMethodUriMappings() {
    return self::$digestUriMapping;
  }

  public function createXmlStructure() {
    parent::createXmlStructure();
    return $this->doc;
  }

  public function getDocument() {
    return $this->doc;
  }
}

