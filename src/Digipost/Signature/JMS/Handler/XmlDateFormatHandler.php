<?php

namespace Digipost\Signature\JMS\Handler;

use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\XmlSchemaDateHandler;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

class XmlDateFormatHandler extends XmlSchemaDateHandler
{
  public function deserializeDateTime(XmlDeserializationVisitor $visitor, $data, array $type) {

    return parent::deserializeDateTime($visitor, $data, $type);
  }

  public function serializeDateTime(
    XmlSerializationVisitor $visitor,
    \DateTime $date,
    array $type,
    Context $context
  ) {
//    if (is_string($date)) {
//      $date = \DateTime::createFromFormat(\DateTime::RFC3339_EXTENDED, $date);
//    }

    $v = $date->format(\DateTime::RFC3339_EXTENDED);
    return $visitor->visitSimpleString($v, $type, $context);
  }
}