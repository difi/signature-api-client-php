<?php

namespace Digipost\Signature\Client\Core\Exceptions;

use Digipost\Signature\API\XML\XMLError;
use Digipost\Signature\Client\Core\Internal\Http\StatusType;

class UnexpectedResponseException extends SignatureException {

  /** @var XMLError */
  protected $error;

  /** @var StatusType */
  protected $actualStatus;

  public function __construct(
    $errorEntity = NULL,
    \Throwable $cause = NULL,
    StatusType $actual = NULL,
    StatusType... $expected
  ) {
    parent::__construct(
      "Expected " . self::prettyprintExpectedStatuses($expected) .
      ", but got " . $actual->getStatusCode() . " " . $actual->getReasonPhrase() .
      ($errorEntity !== NULL ? " {" . $errorEntity . "}" : "") .
      ($cause !== NULL ? "\n\t - " . get_simple_class($cause) . ": '" . $cause->getMessage() .
        "'." : ""),
      $cause
    );
    $this->error = $errorEntity instanceof XMLError ? $errorEntity : NULL;
    $this->actualStatus = $actual;
  }

  public function getActualStatus(): StatusType {
    return $this->actualStatus;
  }

  public function getErrorCode() {
    return $this->error !== NULL ? $this->error->getErrorCode() : NULL;
  }

  public function getErrorMessage() {
    return $this->error !== NULL ? $this->error->getErrorMessage() : NULL;
  }

  public function getErrorType() {
    return $this->error !== NULL ? $this->error->getErrorType() : NULL;
  }

  /**
   * @param StatusType[] $statuses
   *
   * @return String
   */
  private static function prettyprintExpectedStatuses(...$statuses): String {
    $message = "[" . self::prettyprintSingleStatus(reset($statuses[0]));
    for ($i = 1; $i < count($statuses); $i++) {
      $message .= ", " . self::prettyprintSingleStatus(reset($statuses[$i]));
    }

    return $message . "]";
  }

  private static function prettyprintSingleStatus(StatusType $status): String {
    return $status->getStatusCode() . " " . $status->getReasonPhrase();
  }
}

function get_simple_class($object) {
  $className = get_class($object);
  $className = str_replace(__NAMESPACE__ . "\\", '', $className);

  return $className;
}
