<?php
namespace Digipost\Signature\API\XML;

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
	const IN_PROGRESS = 0;
	const COMPLETED_SUCCESSFULLY = 1;
	const FAILED = 2;
}

