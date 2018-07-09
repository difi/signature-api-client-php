<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class CertificateException extends ConfigurationException {
	public static function constructor__String_Exception ($message, $e) // [String message, Exception e]
	{
		$me = new self();
		parent::constructor__String_Exception($message, $e);
		return $me;
	}
	public static function constructor__String ($message) // [String message]
	{
		$me = new self();
		parent::constructor__String($message);
		return $me;
	}
}

