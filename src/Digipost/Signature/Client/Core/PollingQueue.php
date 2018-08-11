<?php

namespace Digipost\Signature\Client\Core;

class PollingQueue {

  /** @var PollingQueue */
  public static $DEFAULT;

  /** @var String */
  public $value;

  public function __construct($value) {
    $this->value = $value;
  }

  public static function of($value) {
    return new PollingQueue($value);
  }

  public static function __staticInit() {
    if (!isset(static::$DEFAULT)) {
      static::$DEFAULT = PollingQueue::of(NULL);
    }
  }

  public function __toString() {
    return $this->value;
  }
}

PollingQueue::__staticInit();
