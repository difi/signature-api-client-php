<?php

namespace Digipost\Signature\JMS\Naming;

use JMS\Serializer\Context;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Naming\AdvancedNamingStrategyInterface;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;

class SigningXMLNamingStrategy implements AdvancedNamingStrategyInterface {

  private $delegate;

  public function __construct(PropertyNamingStrategyInterface $delegate) {
    $this->delegate = $delegate;
  }

  /**
   * Translates the name of the property to the serialized version.
   *
   * @param PropertyMetadata $property
   * @param Context          $context
   *
   * @return string
   */
  public function getPropertyName(
    PropertyMetadata $property,
    Context $context
  ) {

    $currentPath = $context->getCurrentPath();
    $currentLeaf = end($currentPath);
    if ($property->name === 'content') {

      print $property->name . ' : ' . $property->class . ' -> ' . $property->xmlEntryName . "\n";

    }

    return $this->delegate->translateName($property);
    /*
    if ($context->getDirection() == GraphNavigator::DIRECTION_SERIALIZATION) {

    }
    else {
      $currentPath = $context->getCurrentPath();
      //$currentLeaf = array_pop($currentPath);

      if ($context->getDepth() >= 3 && $currentPath[0] === "signatures" && $currentPath[1] === "keyInfo") {
        if ($property->name === 'x509IssuerSerialsAndX509SKISAndX509SubjectNames') {
          //$property->class = X509Certificate::class;
          //$property->name = 'X509Certificate';
          //$property->setType(AnyType::class);
        }

        if ($currentPath[2] === "content" && $context->getDepth() === 3) {
          //$property->class = X509Data::class;
          //$property->name = 'X509Data';
          //$type = 'array<' . X509Data::class . '>';
          $property->setType(X509Data::class);
          return 'X509Data';
          //$property->pr
          //$property->xmlEntryName = 'X509Data';
          //$property->name = 'X509Data';
          $property->xmlEntryNamespace = 'http://www.w3.org/2000/09/xmldsig#';


          //$context->getVisitor()->startVisitingObject(new ClassMetadata(), $data, $property->type, $context);
          //print_r($context->getMetadataFactory());
          //$property->children = [];
          $type = [
            'name' => X509Data::class,
            'params' => [
            ],
          ];
          $context->getNavigator()->accept($property, $type, $context);

          //$context->getVisitor()->
          //$property->setType($type['name']);
          //$context->getNavigator()->accept($property, $type, $context);
          //print_r($property);
          //print "\n";
          //$property->setValue($property, 'testings');
          return 'X509Data';
        }
      }
      if (empty($property->serializedName)) {
//        print self::class . "->getPropertyName(";
//        print $property->serializedName;
//        //$context->pushPropertyMetadata(new PropertyMetadata('test', ''));
//        print ")\n";
      }
    }
    return $this->delegate->translateName($property);
    */
  }
}