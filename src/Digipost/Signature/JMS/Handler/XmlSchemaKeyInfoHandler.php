<?php
namespace Digipost\Signature\JMS\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

class XmlSchemaKeyInfoHandler implements SubscribingHandlerInterface {

  function __construct() {
    print self::class .  " created!\n";
    return $this;
  }


  /**
   * @inheritdoc
   */
  public static function getSubscribingMethods() {
    return [
//      [
//        'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
//        'format' => 'xml',
//        'type' => 'array',
//        'method' => 'deserializeKeyInfoXml',
//      ],
//      [
//        'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
//        'format' => 'xml',
//        'type' => 'array',
//        'method' => 'serializeKeyInfoXml',
//      ],
    ];
  }

  public function deserializeKeyInfoXml(XmlDeserializationVisitor $visitor, $node, array $type, Context $context) {
    print self::class . "->deserializeKeyInfoXml()\n";
    $newType = array(
      'name' => $type["params"][0]["name"],
      'params' => array()
    );
    $ret = array();
    foreach (explode(" ", (string)$node) as $v) {
      $ret[] = $context->accept($v, $newType);
    }
    return $ret;
  }

  public function serializeKeyInfoXml(XmlSerializationVisitor $visitor, $object, array $type, Context $context) {
    print self::class . "->serializeKeyInfoXml()\n";
    $type['name'] = 'array';

    return $visitor->visitArray($object->toArray(), $type, $context);
  }
}