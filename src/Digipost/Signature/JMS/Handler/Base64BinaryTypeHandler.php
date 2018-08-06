<?php

namespace Digipost\Signature\JMS\Handler;

use Digipost\Signature\API\XML\CustomBase64BinaryType;
use Digipost\Signature\Client\Core\Internal\Security\X509Certificate;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

class Base64BinaryTypeHandler implements SubscribingHandlerInterface
{
  /**
   * @inheritdoc
   */
  public static function getSubscribingMethods()
  {
    return [
      [
        'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
        'format' => 'xml',
        'type' => CustomBase64BinaryType::class,
        'method' => 'serializeBase64Data',
      ],
      [
        'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
        'format' => 'xml',
        'type' => CustomBase64BinaryType::class,
        'method' => 'deserializeBase64Data',
      ],
    ];
  }

  public function serializeBase64Data(
    XmlSerializationVisitor $visitor,
    $data,
    array $type,
    Context $context
  ) {
    //$v = $date->format(\DateTime::RFC3339_EXTENDED);
    $base64Data = strval($data);
    $base64Data = X509Certificate::stripDelimitersAndLineWraps($base64Data);
    $base64Data = strtr($base64Data, ["\n" => '']);
    $base64Data = wordwrap($base64Data, 76, "\n", TRUE);
    //$base64Data = "-----BEGIN CERTIFICATE-----\n$base64Data\n-----END CERTIFICATE-----\n";
    //return $visitor->visitSimpleString($v, $type, $context);
    return $visitor->visitSimpleString($base64Data, $type, $context);
  }

  public function deserializeBase64Data(XmlDeserializationVisitor $visitor, $data, array $type)
  {
    $cert = trim((string)$data);
    return $cert;
  }
}