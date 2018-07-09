<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class InvalidStatusQueryTokenException extends SignatureException {
	public static function constructor__String_String ($url, $errorMessageFromServer) // [String url, String errorMessageFromServer]
	{
		$me = new self();
		parent::constructor__String(((("The token in the url '" . $url) . "' was not accepted when querying for status. ") . $errorMessageFromServer));
		return $me;
	}
}

