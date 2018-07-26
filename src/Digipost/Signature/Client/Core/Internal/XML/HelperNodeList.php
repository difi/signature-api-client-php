<?php

namespace Digipost\Signature\Client\Core\Internal\XML;

class HelperNodeList {

  private $nodes;

  private $allNodesMustHaveSameParent;

  /**
   * HelperNodeList constructor.
   *
   * @param bool $sameParent
   */
  function __construct(bool $sameParent = FALSE) {
    $this->allNodesMustHaveSameParent = $sameParent;
    $this->nodes = new \Ds\Set();
  }

  /**
   * @param int $var1
   *
   * @return \DOMNode
   */
  public function item(int $var1): \DOMNode {
    return $this->nodes->get($var1);
  }

  /**
   * @return int
   */
  public function getLength(): int {
    return $this->nodes->count();
  }

  /**
   * @param \DOMNode $var1
   */
  public function appendChild(\DOMNode $var1) {
    if ($this->allNodesMustHaveSameParent && $this->getLength() > 0 && $this->item(0)->parentNode !== $var1->parentNode) {
      throw new \InvalidArgumentException("Nodes have not the same Parent");
    }
    else {
      $this->nodes->add($var1);
    }
  }

  /**
   * @return \DOMDocument
   * @throws \Exception
   */
  public function getOwnerDocument(): \DOMDocument {
    return $this->getLength() === 0 ? NULL : XMLUtils::getOwnerDocument($this->item(0));
  }
}
