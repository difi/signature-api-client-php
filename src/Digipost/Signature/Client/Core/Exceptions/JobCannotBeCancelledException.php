<?php
namespace Digipost\Signature\Client\Core\Exceptions;

class JobCannotBeCancelledException extends SignatureException {
	public static function constructor__StatusType_String_String ($status, $errorCode, $errorMessageFromServer) // [StatusType status, String errorCode, String errorMessageFromServer]
	{
		$me = new self();
		parent::constructor__String((((((((((("The service refused to process the cancellation. This happens when the job has been completed " . "(i.e. all signers have signed or rejected, the job has expired, etc.) since receiving last update. ") . "Please ask the service for status changes to get the latest changes. The server response was ") . $status->getStatusCode()) . " ") . $status->getReasonPhrase()) . " '") . $errorCode) . ": ") . $errorMessageFromServer) . "'"));
		return $me;
	}
}

