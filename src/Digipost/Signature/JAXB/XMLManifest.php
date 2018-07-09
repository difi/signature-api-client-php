<?php

namespace Digipost\Signature\JAXB;

use Digipost\Signature\API\XML\XMLAuthenticationLevel;

interface XMLManifest {

	function getDocument() : XMLDocument;

	function getRequiredAuthentication() : XMLAuthenticationLevel;

  /**
   * @return XMLSigner[] | XMLSigner
   */
  function getSigners();
}
