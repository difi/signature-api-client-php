<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class XmlValidationException extends SignatureException {
	function __construct($message, \Throwable $e)
	{
		parent::__construct($message, 0, $e);
	}
}

