<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use MyCLabs\Enum\Enum;

interface StatusType {

}

class Status {

  static function fromStatusCode($code) {
    return $code;
  }
}

class Custom implements StatusType {

  static function fromStatusCode($code) {
    return $code;
  }
}

class Unknown implements StatusType {

  function __construct($code) {
    $this->code = $code;
  }
}

class ResponseStatus {

  public static function resolve(int $code) {
    $status = Status::fromStatusCode($code);
    if ($status === NULL) {
      $status = Custom::fromStatusCode($code);
    }
    if ($status === NULL) {
      $status = ResponseStatus::unknown($code);
    }
    return $status;
  }

  public static function unknown($code) // [int code]
  {
    return new Unknown($code);
  }
}

