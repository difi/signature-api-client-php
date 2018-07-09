<?php

namespace Digipost\Signature\Client\Core;

class PollingQueue {

  public static $DEFAULT;

  public $value;

  public function __construct($value) {
    $this->value = $value;
    return $this;
  }

  public static function of($value) {
    return new PollingQueue($value);
  }

  public function equals($obj) {
    if ($obj instanceof PollingQueue) {
      $that = clone $obj;
      return $this->value === $that->value;
    }
    return FALSE;
  }

  public function hashCode() {
    return spl_object_hash($this->value);
  }

  public static function __staticInit() {
    self::$DEFAULT = PollingQueue::of(NULL);
  }
}

PollingQueue::__staticinit();

