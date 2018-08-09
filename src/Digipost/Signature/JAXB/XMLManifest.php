<?php

namespace Digipost\Signature\JAXB;

use Digipost\Signature\API\XML\XMLAuthenticationLevel;

interface XMLManifest {

	function getDocument() : XMLDocument;

	function getRequiredAuthentication();

  /**
   * @return XMLSigner[] | XMLSigner
   */
  function getSigners();
}
