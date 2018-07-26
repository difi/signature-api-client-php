<?php

namespace Digipost\Signature\JMS\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

class CustomAnyTypeHandler implements SubscribingHandlerInterface {

  public static function getSubscribingMethods() {
    return [
      [
        'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
        'format' => 'xml',
        'type' => CustomAnyTypeHandler::class,
        'method' => 'deserializeAnyType',
      ],
      [
        'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
        'format' => 'xml',
        'type' => CustomAnyTypeHandler::class,
        'method' => 'serializeAnyType',
      ],
    ];
  }

  public function serializeAnyType(XmlSerializationVisitor $visitor, $object,
                                   array $type, Context $context) {
    $newType = [
      'name' => $type['name'],
      'params' => [],
    ];
    if (isset($type['params'][0])) {
      $newType['name'] = $type['params'][0]['name'];
    }

    $ret = [];
    foreach ($object as $v) {
      $ret[] = $context->accept($v, $newType)->data;
    }

    return $visitor->getDocument()->createTextNode(implode(" ", $ret));
  }

  public function deserializeAnyType(XmlDeserializationVisitor $visitor, $node,
                                     array $type, Context $context) {
    $newType = [
      'name' => $type["params"][0]["name"],
      'params' => [],
    ];
    $ret = [];
    foreach (explode(" ", (string) $node) as $v) {
      $ret[] = $context->accept($v, $newType);
    }
    return $ret;
  }
}