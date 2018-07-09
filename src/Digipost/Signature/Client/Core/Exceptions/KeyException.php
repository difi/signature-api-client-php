<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class KeyException extends ConfigurationException {
	public static function constructor__String_Exception ($message, $e) // [String message, Exception e]
	{
		$me = new self();
		parent::constructor__String_Exception($message, $e);
		return $me;
	}
	public static function constructor__String ($s) // [String s]
	{
		$me = new self();
		parent::constructor__String($s);
		return $me;
	}
}

