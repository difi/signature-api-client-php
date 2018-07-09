<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class XmlConfigurationException extends ConfigurationException {
	public static function constructor__String_Exception ($message, $e) // [final String message, final Exception e]
	{
		$me = new self();
		parent::constructor__String_Exception($message, $e);
		return $me;
	}
}

