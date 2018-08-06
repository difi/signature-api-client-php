<?php
namespace Digipost\Signature\Client\Core\Exceptions;

use Digipost\Signature\Client\Core\Internal\Http\StatusType;

class JobCannotBeCancelledException extends SignatureException {

  function __construct(StatusType $status, $errorCode = NULL, $errorMessageFromServer = NULL) {
    parent::__construct(
      "The service refused to process the cancellation." .
      "This happens when the job has been completed (i.e. all signers have signed or rejected, " .
      "the job has expired, etc.) since receiving last update. Please ask the service for " .
      "status changes to get the latest changes. The server response was " .
      $status->getStatusCode() . " " . $status->getReasonPhrase() . " '" . $errorCode . ": " .
      $errorMessageFromServer . "'");
  }
}
