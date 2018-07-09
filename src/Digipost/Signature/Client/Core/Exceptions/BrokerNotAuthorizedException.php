<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class BrokerNotAuthorizedException extends SignatureException {
	public static function constructor__XMLError ($error) // [XMLError error]
	{
		$me = new self();
		parent::constructor__String($error->getErrorMessage());
		return $me;
	}
}

