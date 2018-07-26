<?php

namespace Digipost\Signature\JMS\Handler;

use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\XmlSchemaDateHandler;
use JMS\Serializer\Context;
use JMS\Serializer\XmlSerializationVisitor;

class XmlDateFormatHandler extends XmlSchemaDateHandler
{

  public function serializeDateTime(
    XmlSerializationVisitor $visitor,
    \DateTime $date,
    array $type,
    Context $context
  ) {
    $v = $date->format(\DateTime::RFC3339_EXTENDED);

    return $visitor->visitSimpleString($v, $type, $context);
  }
}