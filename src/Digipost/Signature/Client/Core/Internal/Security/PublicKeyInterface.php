<?php
namespace Digipost\Signature\Client\Core\Internal\Security;

interface PublicKeyInterface extends \Serializable, Key  {
  function getAlgorithm(): String;

  function getFormat(): String;

  function getEncoded(): String;
}
