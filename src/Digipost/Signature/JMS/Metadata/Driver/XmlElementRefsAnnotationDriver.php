<?php

namespace Digipost\Signature\JMS\Metadata\Driver;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfoReference;
use Digipost\Signature\Client\Core\Internal\XML\XMLStructure;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\Driver\AnnotationDriver;

class XmlElementRefsAnnotationDriver extends AnnotationDriver {


  public function loadMetadataForClass(\ReflectionClass $class): ClassMetadata {
    $classMetadata = parent::loadMetadataForClass($class);

    if ($class->getName() === XMLStructure::class) {
      print $class->getName();
    }
    if ($class->getName() === KeyInfoReference::class) {
      //print $class->getName() . "\n";
      //      $classMetadata->discriminatorFieldName = "KeyInfo";
      //      $classMetadata->discriminatorValue = "X509Data";
      //$propertyMetadata = $classMetadata->propertyMetadata;
      //      $propertiesMetadata = [];
      //      foreach ($class->getProperties() as $property) {
      //        $propertiesMetadata[] = $property;
      //      }
      //print count($propertiesMetadata) . " properties...\n";
    }

    return $classMetadata;
  }
}