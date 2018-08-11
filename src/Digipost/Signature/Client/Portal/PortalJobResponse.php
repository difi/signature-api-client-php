<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\Client\Core\Internal\Cancellable;

class PortalJobResponse implements Cancellable {

  /** @var int */
  protected $signatureJobId;

  /** @var String */
  private $reference;

  /** @var CancellationUrl */
  protected $cancellationUrl;

  function __construct(int $signatureJobId, String $reference, CancellationUrl $cancellationUrl) {
    $this->signatureJobId = $signatureJobId;
    $this->reference = $reference;
    $this->cancellationUrl = $cancellationUrl;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function getCancellationUrl(): CancellationUrl {
    return $this->cancellationUrl;
  }
}

