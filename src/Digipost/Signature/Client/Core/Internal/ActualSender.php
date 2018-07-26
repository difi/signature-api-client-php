<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\Exceptions\SenderNotSpecifiedException;
use Digipost\Signature\Client\Core\Sender;

class ActualSender {

  public static function getActualSender(
    Sender $messageSpecificSender = NULL,
    Sender $globalSender = NULL
  ) {
    if (isset($messageSpecificSender)) {
      return $messageSpecificSender;
    }
    if (isset($globalSender)) {
      return $globalSender;
    }
    throw new SenderNotSpecifiedException();
  }
}

