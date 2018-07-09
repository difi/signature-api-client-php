<?php

namespace Digipost\Signature\Client\Core\Exceptions;

class SenderNotSpecifiedException extends SignatureException {

  public static $SENDER_NOT_SPECIFIED = SenderNotSpecifiedException::class;

  function __construct() {
    parent::__construct("Sender is not specified. Please call ClientConfiguration#sender to set it globally, " .
                        "or DirectJob.Builder#withSender or PortalJob.Builder#withSender if you need to specify sender " .
                        "on a per job basis (typically when acting as a broker on behalf of multiple senders).");
  }
}
