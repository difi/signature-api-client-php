<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 18.06.18
 * Time: 16:56
 */

namespace Digipost\Signature\JAXB;

class JAXBElement {

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
  public function __construct(QName $QName, String $declaredType,
                              String $scope = NULL, $value = NULL) {
    $this->name = $QName;
    $this->declaredType = $declaredType;
    $this->scope = $scope;
    $this->value = $value;
  }
}