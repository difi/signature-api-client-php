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
 * @method static DirectJobStatus IN_PROGRESS
 * @method static DirectJobStatus COMPLETED_SUCCESSFULLY
 * @method static DirectJobStatus FAILED
 * @method static DirectJobStatus NO_CHANGES
 */
class DirectJobStatus extends Enum implements MarshallableEnum {

  const IN_PROGRESS = XMLDirectSignatureJobStatus::IN_PROGRESS;

  const COMPLETED_SUCCESSFULLY = XMLDirectSignatureJobStatus::COMPLETED_SUCCESSFULLY;

  const FAILED = XMLDirectSignatureJobStatus::FAILED;

  const NO_CHANGES = 'NO_CHANGES';

  function getXmlEnumValue() {
    return new XMLDirectSignatureJobStatus($this->value);
  }

  static function fromXmlType(XMLDirectSignatureJobStatus $xmlValue) {
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
