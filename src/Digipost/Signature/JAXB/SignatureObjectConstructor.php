<?php

namespace Digipost\Signature\JAXB;

use Digipost\Signature\API\XML\XMLDirectSignatureJobResponse;
use Ds\Set;
use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\VisitorInterface;

class SignatureObjectConstructor implements ObjectConstructorInterface {

  /**
   * @var Set
   */
  private $setClasses;

  /**
   * Constructs a new object.
   *
   * Implementations could for example create a new object calling "new", use
   * "unserialize" techniques, reflection, or other means.
   *
   * @param VisitorInterface       $visitor
   * @param ClassMetadata          $metadata
   * @param mixed                  $data
   * @param array                  $type ["name" => string, "params" => array]
   * @param DeserializationContext $context
   *
   * @return object
   */
  public function construct(VisitorInterface $visitor, ClassMetadata $metadata,
                            $data, array $type,
                            DeserializationContext $context) {


//    print_r($type);
//    print "\n----\n";
//    print_r($this->setClasses->toArray());
    $className = XMLDirectSignatureJobResponse::class;
    if ($this->setClasses->contains($type['name'])) {
      print "JUHUUUUUUUUUUUU\n\n";
    } else {
      $className = $type['name'];
    }
    $object = NULL;
    try {
      $object = new \ReflectionClass($className);
    } catch (\ReflectionException $e) {
    }

    return $object->newInstanceWithoutConstructor();
  }

  public static function fromClassSet(Set $classes) {
    $self = new self();
    $self->setClasses = $classes;
    return $self;
  }
}