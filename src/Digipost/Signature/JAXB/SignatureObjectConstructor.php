<?php

namespace Digipost\Signature\JAXB;

use Doctrine\Instantiator\Instantiator;
use Ds\Set;
use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\VisitorInterface;

class SignatureObjectConstructor implements ObjectConstructorInterface {

  private $fallbackConstructor;

  /**
   * @var Set
   */
  private $setClasses;

  /**
   * @var string
   */
  private $documentType;

  /**
   * @var Instantiator
   */
  private $instantiator;

  public function __construct(
    ObjectConstructorInterface $fallbackConstructor = NULL
  ) {
    if (isset($fallbackConstructor)) {
      $this->fallbackConstructor = $fallbackConstructor;
    }
  }

  /**
   * @return Instantiator
   */
  private function getInstantiator() {
    if (!isset($this->instantiator)) {
      $this->instantiator = new Instantiator();
    }

    return $this->instantiator;
  }

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
  public function construct(
    VisitorInterface $visitor,
    ClassMetadata $metadata,
    $data,
    array $type,
    DeserializationContext $context
  ) {

    $object = $this->getInstantiator()->instantiate($metadata->name);
    if (!empty($metadata->discriminatorMap)) {
      print \json_encode($metadata->discriminatorMap) . "\n";
    }


    return $object;

    /*
    // TODO: clean up/fix this properly.
    $className = AnyType::class;
    if (isset($this->documentType) && $context->getDepth() === 1) {
      $className = $this->documentType;
      print "\nYEEEEEEEESSS: $className\n\n";
      //$type['name'] = $this->documentType;
    }
    else {
      print "\n";
      print $context->getDepth() . "\t" . $type['name'];
      print "\n";
      if ($this->setClasses->contains($type['name'])) {
        //print "JUHUUUUUUUUUUUU\n\n";
      }
      else {
        $className = $type['name'];
      }
      if ($type['name'] == X509Data::class) {
        //print_r($type);
      }
    }

    if ($context->getDepth() >= 3) {
      //print_r($type);
      //print_r($data);
    }

    if (strpos($type['name'], 'KeyInfo') !== -1) {
//      print "\n------ KeyInfo ---------\n";
//      print_r($data);
//      print_r($type);
//      echo "OK";
    }


    $object = NULL;
    try {
      $object = new $className();
    } catch (\ReflectionException $e) {
      throw new \RuntimeException($e);
    }

    //return $object->newInstanceWithoutConstructor();
    return $object;
    */
  }

  public function setFallbackConstructor(ObjectConstructorInterface $constructor
  ) {
    $this->fallbackConstructor = $constructor;
    return $this;
  }

  public function setDocumentType($className) {
    $this->documentType = $className;
    return $this;
  }

  public static function fromClassSet(Set $classes) {
    $self = new self();
    $self->setClasses = $classes;
    return $self;
  }

  public function getSetClasses(): Set {
    return $this->setClasses;
  }

  public function setSetClasses(Set $setClasses) {
    $this->setClasses = $setClasses;
  }
}