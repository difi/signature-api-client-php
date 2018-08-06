<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class DocumentsNotDeletableException extends SignatureException {

  public function __construct(string $message = "", \Throwable $previous = NULL) {
    parent::__construct(
      "Unable to delete documents. This is most likely because the job has not been completed. " .
      "Only completed jobs can be deleted, please verify the job's status.");
  }
}
