<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\Internal\Security\PrivateKey;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\SerializationContext;

/**
 * Class XMLSignContext
 *
 * @package Digipost\Signature\Client\Core\Internal
 */
class XMLSignContext {

  /**
   *
   */
  protected $privateKey;

  /**
   * 
   */
  protected $document;

  function __construct(PrivateKey $privateKey, \DOMDocument $document) {
//    parent::__construct();
    $this->privateKey = $privateKey;
    $this->document = $document;
  }


  function getParent() {
    return $this->document;
  }
  function getNexSibling() {
    return $this->document->nextSibling;
  }
//  public function __construct(string $name, string $value, string $uri) {
//    parent::__construct($name, $value, $uri);
//  }
}