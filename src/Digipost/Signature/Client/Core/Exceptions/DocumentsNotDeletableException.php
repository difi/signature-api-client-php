<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class DocumentsNotDeletableException extends SignatureException {
	public static function constructor__ () 
	{
		$me = new self();
		parent::constructor__String("Unable to delete documents. This is most likely because the job has not been completed. Only completed jobs can be deleted, please verify the job's status.");
		return $me;
	}
}

