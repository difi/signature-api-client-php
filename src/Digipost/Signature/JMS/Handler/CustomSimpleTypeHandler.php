<?php

namespace Digipost\Signature\JMS\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

class CustomSimpleTypeHandler implements SubscribingHandlerInterface
{
  public static function getSubscribingMethods()
  {
    return array(
      array(
        'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
        'format' => 'xml',
        'type' => CustomSimpleTypeHandler::class,
        'method' => 'deserializeSimpleType'
      ),
      array(
        'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
        'format' => 'xml',
        'type' => CustomSimpleTypeHandler::class,
        'method' => 'serializeSimpleType'
      ),
    );
  }

  public function serializeSimpleType(XmlSerializationVisitor $visitor, $data, array $type, Context $context)
  {
    if (gettype($data) === 'Object') {
      $test = $visitor->visitArray($data, $type, $context);
      return $test;
    }
    //return $visitor->visitString((string) $data, $type, $context);
//    if (is_array($data)) {
//    }

    $ret = $visitor->visitString($data, $type, $context);
    if ($ret instanceof \DOMCharacterData) {
      //$ret = $ret->textContent;
      //$ret = "heisann";
      //return $ret;
    } else {
      //return strval($ret);
    }
    return $ret;
  }

  public function deserializeSimpleType(XmlDeserializationVisitor $visitor, $data, array $type)
  {
    $ret = (string) $data;

    return $ret;
  }

  public function serializeX509Certificate(XmlSerializationVisitor $visitor, $data, array $type, Context $context) {
//    print "Hei";
//    $type = get_class($data);

    return $visitor->getNavigator()->accept((string) $data, $type, $context);
  }

  public function deSerializeX509Certificate(XmlDeserializationVisitor $visitor, $data, array $type) {
//    print "Hei";
//    $type = get_class($data);
    return strval($data);
  }
}