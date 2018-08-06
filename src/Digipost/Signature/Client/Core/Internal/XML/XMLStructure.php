<?php

namespace Digipost\Signature\Client\Core\Internal\XML;

use Digipost\Signature\API\XML\Thirdparty\XAdES\QualifyingProperties;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\ObjectXsd;
use JMS\Serializer\Annotation as Serializer;

class XMLStructure {

  /**
   * @var \DOMNode
   * @Serializer\Exclude()
   */
  private $node;

  /**
   * @Serializer\Exclude()
   */
  private $content;

  public function __construct(\DOMNode $node) {
    $this->node = $node;
  }

  public function getNode(): \DOMNode {
    return $this->node;
  }

  public function unmarshal() {
    $document = $this->node->ownerDocument;
    $xmlData = $document->saveXML($this->node, Marshalling::LIBXML_OPTIONS);
    $this->content = Marshalling::unmarshal($xmlData, QualifyingProperties::class);
  }

  public function marshal() {
    Marshalling::marshal($this->content, $domOutput);
    /** @var \DOMDocument $domOutput */
    $this->node = $domOutput->documentElement;
  }
//  public function __get($name) {
//
//    return $name;
//  }

//  public function __call($name, $arguments) {
//    $type = gettype($this->content);
//    return "Calling $type :: $name ...";
//  }

  /**
   * @return mixed
   */
  public function &getContent() {
    if (!isset($this->content)) {
      $this->unmarshal();
    }
    return $this->content;
  }
  /**
   * @param mixed $content
   */
  public function setContent($content) {
    $this->content = $content;
  }
}