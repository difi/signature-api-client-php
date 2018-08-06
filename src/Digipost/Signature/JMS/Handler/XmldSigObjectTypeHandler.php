<?php

namespace Digipost\Signature\JMS\Handler;

use Digipost\Signature\API\XML\Thirdparty\XAdES\QualifyingProperties;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\ObjectType;
use Digipost\Signature\Client\Core\Internal\XML\XMLStructure;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\Metadata\StaticPropertyMetadata;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

class XmldSigObjectTypeHandler implements SubscribingHandlerInterface
{

  public static function getSubscribingMethods()
  {
    return [
      [
        'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
        'format' => 'xml',
        'type' => ObjectType::class,
        'method' => 'deserializeObjectType',
      ],
      [
        'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
        'format' => 'xml',
        'type' => ObjectType::class,
        'method' => 'serializeObjectType',
      ],
      [
          'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
          'format' => 'xml',
          'type' => XMLStructure::class,
          'method' => 'serializeXMLStructure',
        ],
    ];
  }

  public function serializeXMLStructure(
    XmlSerializationVisitor $visitor,
    $object,
    array $type,
    Context $context
  ) {
    if (is_array($object)) {
      foreach ($object as $x => $obj) {
        print gettype($obj);
      }
    }
    print gettype($obj);
  }

  public function serializeObjectType(
    XmlSerializationVisitor $visitor,
    $object,
    array $type,
    Context $context
  ) {

    //$value = $object->value();
    if (is_array($object)) {
      return $visitor->visitArray($object, $type, $context);
    }

    if ($object instanceof XMLStructure) {
      $classMetadata = $context->getMetadataFactory()->getMetadataForClass(XMLStructure::class);
      return $visitor->visitArray($object, $type, $context);
    }

    if ($object instanceof ObjectType) {
      $classMetadata = $context->getMetadataFactory()->getMetadataForClass(ObjectType::class);
      $visitor->startVisitingObject($classMetadata, $object, $type, $context);

      $metadata = new StaticPropertyMetadata(
        QualifyingProperties::class, 'QualifyingProperties', $object->getContent()
      );
      $metadata->xmlEntryName = 'QualifyingProperties';
      $visitor->visitProperty($metadata, $object->getContent(), $context);
      //foreach ((array)$object as $name => $value) {
      //$metadata = new StaticPropertyMetadata(ObjectType::class, $name, $value);
      //echo "Visiting property $name (" . gettype($value) . ")...\n";
      //$visitor->visitProperty($metadata, $value, $context);
      //}
      return $visitor->endVisitingObject($classMetadata, $object, array('name' => ObjectType::class), $context);
    }

    return $visitor->getDocument()->createTextNode(implode(" ", $object));
  }

  public function deserializeObjectType(
    XmlDeserializationVisitor $visitor,
    $node,
    array $type,
    Context $context
  ) {

    $newType = [
      'name' => isset($type["params"][0]) ? $type["params"][0]["name"] : $type['name'],
      'params' => [],
    ];

    $ret = [];
    foreach ($node as $name => $v) {
      $newType['name'] = $name;
      if ($name === 'QualifyingProperties') {
        $metadata = new StaticPropertyMetadata(
          QualifyingProperties::class, 'QualifyingProperties', $v
        );
        $metadata->xmlEntryName = 'QualifyingProperties';
        $newType['name'] = QualifyingProperties::class;
      }
      $ret[] = $context->accept($v, $newType);
    }

    return $ret;
  }
}