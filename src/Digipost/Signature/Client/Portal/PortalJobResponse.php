<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\Client\Core\Internal\Cancellable;

class PortalJobResponse implements Cancellable {

  protected $signatureJobId;

  protected $cancellationUrl;

  function __construct(int $signatureJobId,
                       CancellationUrl $cancellationUrl) {
    $this->signatureJobId = $signatureJobId;
    $this->cancellationUrl = $cancellationUrl;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function getCancellationUrl() {
    return $this->cancellationUrl;
  }
}

