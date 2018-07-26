<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

interface Key extends \Serializable {

  const serialVersionUID = 6603384152749567654;

  function getAlgorithm(): String;

  function getFormat(): String;

  function getEncoded(): String;
}