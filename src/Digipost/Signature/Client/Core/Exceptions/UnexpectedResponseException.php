<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class UnexpectedResponseException extends SignatureException {
	protected $error;	// XMLError
	protected $actualStatus;	// StatusType
	public static function constructor__Object_StatusType_StatusType ($errorEntity, $actual, $expected) // [Object errorEntity, StatusType actual, StatusType... expected]
	{
		$me = new self();
		self::constructor__Object_Throwable_StatusType_StatusType($errorEntity, NULL, $actual, $expected);
		return $me;
	}
	public static function constructor__Object_Throwable_StatusType_StatusType ($errorEntity, $cause, $actual, $expected) // [Object errorEntity, Throwable cause, StatusType actual, StatusType... expected]
	{
		$me = new self();
		parent::constructor__String_Throwable(((((((("Expected " . UnexpectedResponseException::prettyprintExpectedStatuses($expected)) . ", but got ") . $actual->getStatusCode()) . " ") . $actual->getReasonPhrase()) . (( (($errorEntity != NULL)) ? ((" [" . $errorEntity) . "]") : "" ))) . (( (($cause != NULL)) ? ((((" - " . $cause->getClass()->getSimpleName()) . ": '") . $cause->getMessage()) . "'.") : "" ))), $cause);
		$me->error = ( ($errorEntity instanceof XMLError) ? $errorEntity : NULL );
		$me->actualStatus = $actual;
		return $me;
	}
	public function getActualStatus () 
	{
		return $this->actualStatus;
	}
	public function getErrorCode () 
	{
		return ( (($this->error != NULL)) ? $this->error->getErrorCode() : NULL );
	}
	public function getErrorMessage () 
	{
		return ( (($this->error != NULL)) ? $this->error->getErrorMessage() : NULL );
	}
	public function getErrorType () 
	{
		return ( (($this->error != NULL)) ? $this->error->getErrorType() : NULL );
	}
	protected static function prettyprintExpectedStatuses ($statuses) // [StatusType... statuses]
	{
		$message = ("[" . UnexpectedResponseException::prettyprintSingleStatus($statuses[0]));
		for ($i = 1; ($i < count($statuses) /*from: statuses.length*/); ++$i) 
		{
			$message += (", " . UnexpectedResponseException::prettyprintSingleStatus($statuses[$i]));
		}
		return ($message . "]");
	}
	protected static function prettyprintSingleStatus ($status) // [StatusType status]
	{
		return (($status->getStatusCode() . " ") . $status->getReasonPhrase());
	}
}

