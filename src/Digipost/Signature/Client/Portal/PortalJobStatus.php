<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\API\XML\XMLPortalSignatureJobStatus;
use MyCLabs\Enum\Enum;

/**
 * Class PortalJobStatus
 *
 * @package Digipost\Signature\Client\Portal
 *
 * @method static PortalJobStatus IN_PROGRESS()
 * @method static PortalJobStatus COMPLETED_SUCCESSFULLY()
 * @method static PortalJobStatus FAILED()
 * @method static PortalJobStatus NO_CHANGES()
 */
class PortalJobStatus extends Enum {
  /**
   * Indicates that there has been a change to the job, but that it has not been signed by all signers yet.
   * For details about the state, see the {@link SignatureStatus status} of each signer.
   *
   * When the client {@link Confirmable confirms} a job with this status,
   * the job is removed from the queue and will not be returned upon subsequent polling,
   * until the status has changed again.
   */
  const IN_PROGRESS = 'IN_PROGRESS';

  /**
   * Indicates that the signature job has completed successfully with signatures from all signers.
   *
   * When the client {@link Confirmable confirms} a job with this status,
   * the job and its associated resources will become unavailable through the Signature API.
   */
  const COMPLETED_SUCCESSFULLY = 'COMPLETED_SUCCESSFULLY';

  /**
   * Indicates that the signature job failed. For details about the failure, see the
   * {@link SignatureStatus status} of each signer.
   *
   * When the client {@link Confirmable confirms} a job with this status,
   * the job and its associated resources will become unavailable through the Signature API.
   */
  const FAILED = 'FAILED';

  /**
   * There has not been any changes since the last received status change.
   */
  const NO_CHANGES = 'NO_CHANGES';

  public static function fromXmlType(XMLPortalSignatureJobStatus $xmlJobStatus) {
    switch ($xmlJobStatus) {
      case XMLPortalSignatureJobStatus::IN_PROGRESS:
        return self::IN_PROGRESS();
      case XMLPortalSignatureJobStatus::COMPLETED_SUCCESSFULLY:
        return self::COMPLETED_SUCCESSFULLY();
      case XMLPortalSignatureJobStatus::FAILED:
        return self::FAILED();
      default:
        throw new \InvalidArgumentException('Unexpected status: ' . $xmlJobStatus);
    }
  }
}
