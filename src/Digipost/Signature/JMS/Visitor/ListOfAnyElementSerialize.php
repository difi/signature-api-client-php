<?php

namespace Digipost\Signature\JMS\Visitor;

use JMS\Serializer\Accessor\AccessorStrategyInterface;
use JMS\Serializer\XmlSerializationVisitor;

/**
 * Class ListOfAnyElementSerialize
 *
 * @package Digipost\Signature\JMS\Visitor
 * @inheritdoc
 */
class ListOfAnyElementSerialize extends XmlSerializationVisitor {

  /**
   * @inheritdoc
   */
  function __construct(
    $namingStrategy,
    AccessorStrategyInterface $accessorStrategy = NULL
  ) {
    parent::__construct($namingStrategy, $accessorStrategy);
  }
}