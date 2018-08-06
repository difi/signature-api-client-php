<?php

namespace Digipost\Signature\Client\Core\Internal;

class PersonalIdentificationNumbers {

  public static function mask($personalIdentificationNumber) {
    if (!isset($personalIdentificationNumber)) {
      return NULL;
    }
    else {
      if (strlen($personalIdentificationNumber) < 6) {
        return $personalIdentificationNumber;
      }
    }
    $masking = str_repeat('*', strlen($personalIdentificationNumber) - 6);

    return substr($personalIdentificationNumber, 0, 6) . $masking;
  }
}
