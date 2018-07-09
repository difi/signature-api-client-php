<?php
namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\AuthenticationLevel;
use Digipost\Signature\Client\Core\IdentifierInSignedDocuments;
use Digipost\Signature\Client\Core\Sender;

interface JobCustomizations {

  function withSender(Sender $sender);

  function requireAuthentication(AuthenticationLevel $minimumLevel);

  function withReference($uuid_or_reference);

  function withIdentifierInSignedDocuments(IdentifierInSignedDocuments $identifier);
}

