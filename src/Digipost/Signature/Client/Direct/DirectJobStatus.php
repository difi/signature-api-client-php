<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\API\XML\XMLDirectSignatureJobStatus;
use Digipost\Signature\Client\Core\Internal\MarshallableEnum;
use MyCLabs\Enum\Enum;

/**
 * Class DirectJobStatus
 *
 * @package Digipost\Signature\Client\Direct
 *
 * @method static DirectJobStatus IN_PROGRESS()             At least one signer has not yet performed any action to the document. For details about the state, see the SignerStatus of each signer.
 * @method static DirectJobStatus COMPLETED_SUCCESSFULLY()  All signers have successfully signed the document.
 * @method static DirectJobStatus FAILED()                  All signers have performed an action to the document, but at least one have a non successful status (e.g. rejected, expired or failed).
 * @method static DirectJobStatus NO_CHANGES()              There has not been any changes since the last received status change.
 */
class DirectJobStatus extends Enum implements MarshallableEnum {

  /**
   * At least one signer has not yet performed any action to the document.
   * For details about the state, see the {@link SignerStatus status} of each signer.
   *
   * @see XMLDirectSignatureJobStatus::IN_PROGRESS
   */
  const IN_PROGRESS = XMLDirectSignatureJobStatus::IN_PROGRESS;

  /**
   * All signers have successfully signed the document.
   *
   * @see XMLDirectSignatureJobStatus::COMPLETED_SUCCESSFULLY
   */
  const COMPLETED_SUCCESSFULLY = XMLDirectSignatureJobStatus::COMPLETED_SUCCESSFULLY;

  /**
   * All signers have performed an action to the document, but at least one have a non successful status (e.g. rejected, expired or failed).
   *
   * @see XMLDirectSignatureJobStatus::FAILED
   */
  const FAILED = XMLDirectSignatureJobStatus::FAILED;

  /**
   * There has not been any changes since the last received status change.
   */
  const NO_CHANGES = 'NO_CHANGES';

  function getXmlEnumValue() {
    return new XMLDirectSignatureJobStatus($this->value);
  }

  static function fromXmlType($xmlValue = NULL) {
    switch ($xmlValue) {
      case self::IN_PROGRESS:
        return self::IN_PROGRESS();
      case self::COMPLETED_SUCCESSFULLY:
        return self::COMPLETED_SUCCESSFULLY();
      case self::FAILED:
        return self::FAILED();
      default:
        throw new \InvalidArgumentException("Unexpected status: " . $xmlValue);
    }
  }
}
