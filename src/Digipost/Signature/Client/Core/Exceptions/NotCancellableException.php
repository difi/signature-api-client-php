<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class NotCancellableException extends SignatureException {
	public static function constructor__ () 
	{
		$me = new self();
		parent::constructor__String("Unable to cancel job. This is most likely because the job has been completed. Only newly created and partially completed jobs can be cancelled, please verify the job's status.");
		return $me;
	}
}

