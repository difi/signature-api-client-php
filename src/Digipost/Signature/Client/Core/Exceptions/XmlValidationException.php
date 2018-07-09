<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class XmlValidationException extends SignatureException {
	function __construct($message, $code, $e)
	{
		parent::__construct($message, $code, $e);
		return $this;
	}
}

