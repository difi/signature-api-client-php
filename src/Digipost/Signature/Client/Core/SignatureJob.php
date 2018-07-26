<?php

namespace Digipost\Signature\Client\Core;

interface SignatureJob {

  /**
   * @return Document
   */
  function getDocument();

  function getSender();

  function getReference();

  function getRequiredAuthentication();

  function getIdentifierInSignedDocuments();
}


