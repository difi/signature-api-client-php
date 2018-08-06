<?php

namespace Digipost\Signature\API\XML;

use Digipost\Signature\Client\Core\Internal\MarshallableEnum;
use MyCLabs\Enum\Enum;

/**
 * Class XMLDirectSignatureJobStatus
 *
 * <p>Java class for direct-signature-job-status.
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 * <p>
 * <pre>
 * <simpleType name="direct-signature-job-status">
 *   <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *     <enumeration value="IN_PROGRESS"/>
 *     <enumeration value="COMPLETED_SUCCESSFULLY"/>
 *     <enumeration value="FAILED"/>
 *   </restriction>
 * </simpleType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 */
class XMLDirectSignatureJobStatus extends Enum {

  /**
   * At least one signer has not yet performed any action to the document.
   */
  const IN_PROGRESS = 'IN_PROGRESS';

  /**
   * All signers have successfully signed the document.
   */
  const COMPLETED_SUCCESSFULLY = 'COMPLETED_SUCCESSFULLY';

  /**
   * All signers have performed an action to the document, but at least one
   * have a non successful status (e.g. rejected, expired or failed).
   */
  const FAILED = 'FAILED';
}
