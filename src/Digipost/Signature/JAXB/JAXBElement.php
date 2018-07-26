<?php

namespace Digipost\Signature\JAXB;

/**
 * Class JAXBElement
 *
 * @package Digipost\Signature\JAXB
 */
class JAXBElement implements \Serializable {

  protected $name;

  protected $declaredType;

  protected $scope;

  protected $value;

  /**
   * JAXBElement constructor.
   *
   * @param QName  $QName
   * @param String $declaredType
   * @param String $scope
   * @param mixed  $value
   */
  public function __construct(
    QName $QName = NULL,
    String $declaredType = NULL,
    String $scope = NULL,
    $value = NULL
  ) {
    $this->name = $QName;
    $this->declaredType = $declaredType;
    $this->scope = $scope;
    $this->value = $value;
  }

  /**
   * @return JAXBElement
   */
  public static function fromString(
    $name = "",
    $declaredType = NULL,
    $scope = NULL,
    $value = NULL
  ) {
    return new self($name, $declaredType, $scope, $value);
  }

  /**
   * @inheritdoc
   */
  public function serialize() {
    // TODO: Implement serialize() method.
  }

  /**
   * @inheritdoc
   */
  public function unserialize($serialized) {
    // TODO: Implement unserialize() method.
  }
}