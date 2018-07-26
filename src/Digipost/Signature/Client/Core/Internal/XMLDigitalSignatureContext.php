<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\Internal\Security\PrivateKey;
use Psr\Container\ContainerInterface;
use Sabre\Xml;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use XmlDsig\XmlDigitalSignature;

class XMLDigitalSignatureContext extends XmlDigitalSignature {
  use ContainerAwareTrait;

  static $digestUriMapping = [];

  /** @var PrivateKey */
  private $_privateKey;

  /** @var \DOMDocument */
  private $_document;

  /** @var \Sabre\Xml\Service */
  private $_xmlService;

  function __construct() {
    //$this->digestMethodUriMapping
    //    self::DIGEST_SHA1		=> 'http://www.w3.org/2000/09/xmldsig#sha1',
    //		self::DIGEST_SHA256		=> 'http://www.w3.org/2001/04/xmlenc#sha256',
    //		self::DIGEST_SHA512		=> 'http://www.w3.org/2001/04/xmlenc#sha512',
    //		self::DIGEST_RIPEMD160	=> 'http://www.w3.org/2001/04/xmlenc#ripemd160',
    $this->createStaticUriMappings();
  }
  function configure(PrivateKey $privateKey, \DOMDocument $document) {
    $this->_privateKey = $privateKey;
    $this->_document = $document;
    return $this;
  }

  public static function factory(ContainerInterface $container, Xml\Service $xmlService) {
    $self = new self();
    $self->setContainer($container);
    $self->setXmlService($xmlService);
    return $self;
  }

  public function setXmlService(Xml\Service $xmlService) {
    $this->_xmlService = $xmlService;
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

