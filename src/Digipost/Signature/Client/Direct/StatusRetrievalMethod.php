<?php
namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\Client\Core\Internal\MarshallableEnum;
use Digipost\Signature\API\XML\XMLStatusRetrievalMethod;
use MyCLabs\Enum\Enum;

/**
 * Class StatusRetrievalMethod
 *
 * @package Digipost\Signature\Client\Direct
 *
 * @method static StatusRetrievalMethod WAIT_FOR_CALLBACK
 * @method static StatusRetrievalMethod POLLING
 */
class StatusRetrievalMethod extends Enum implements MarshallableEnum {
	const WAIT_FOR_CALLBACK = XMLStatusRetrievalMethod::WAIT_FOR_CALLBACK;
	const POLLING = XMLStatusRetrievalMethod::POLLING;

  public function getXmlEnumValue() {
    return new XMLStatusRetrievalMethod($this->value);
  }
}
