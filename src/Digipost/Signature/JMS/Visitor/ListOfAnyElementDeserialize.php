<?php

namespace Digipost\Signature\JMS\Visitor;

use JMS\Serializer\Accessor\AccessorStrategyInterface;
use JMS\Serializer\XmlDeserializationVisitor;

/**
 * Class ListOfAnyElementDeserialize
 *
 * @package Digipost\Signature\JMS\Visitor
 * @inheritdoc
 */
class ListOfAnyElementDeserialize extends XmlDeserializationVisitor {

  /** @var \SplStack */
  //  private $metadataStack;
  //
  //  private $currentMetadata;

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