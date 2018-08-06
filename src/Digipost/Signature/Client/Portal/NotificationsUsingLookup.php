<?php

namespace Digipost\Signature\Client\Portal;

use MyCLabs\Enum\Enum;

/**
 * Class NotificationsUsingLookup
 *
 * @package Digipost\Signature\Client\Portal
 *
 * @method static NotificationsUsingLookup EMAIL_ONLY()
 * @method static NotificationsUsingLookup EMAIL_AND_SMS()
 */
class NotificationsUsingLookup extends Enum {

  const EMAIL_ONLY    = [TRUE, FALSE];
  const EMAIL_AND_SMS = [TRUE, TRUE];

  public $shouldSendEmail;
  public $shouldSendSms;

  function __construct($value) {
    parent::__construct($value);

    $this->shouldSendEmail = $this->value[0];
    $this->shouldSendSms = $this->value[1];
  }

  public function shouldSendEmail() {
    return $this->shouldSendEmail;
  }
  public function shouldSendSms() {
    return $this->shouldSendSms;
  }
}
