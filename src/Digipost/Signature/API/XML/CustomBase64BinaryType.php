<?php

namespace Digipost\Signature\API\XML;

class CustomBase64BinaryType {

  private $__value = NULL;

  function __construct($value = NULL) {
    $this->value($value);
  }

  public function value($value = NULL) {
    if (isset($value)) {
      $this->__value = $value;

      return $this;
    }

    return $this->__value;
  }

  function __toString() {
    $str = $this->__value;;
    if (is_array($this->__value)) {
      $str = implode(" ", $this->__value);
    }
    if (!isset($this->__value)) {
      return '';
    }
    return wordwrap($str, 76, "\n", TRUE);
  }
}