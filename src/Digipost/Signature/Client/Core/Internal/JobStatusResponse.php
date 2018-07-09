<?php

namespace Digipost\Signature\Client\Core\Internal;

class JobStatusResponse {

  protected $status;  // JOB_STATUS

  protected $nextPermittedPollTime;  // Instant

  public function __construct($status, $nextPermittedPollTime) {
    $this->status = $status;
    $this->nextPermittedPollTime = $nextPermittedPollTime;
  }

  public function getStatusResponse() {
    return $this->status;
  }

  public function gotStatusChange() {
    return ($this->status !== NULL);
  }

  public function getNextPermittedPollTime() {
    return $this->nextPermittedPollTime;
  }
}

