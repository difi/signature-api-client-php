<?php
namespace Digipost\Signature\Client\Core\Internal\Security;

interface PrivateKeyInterface extends \Serializable, Key  {
  function getAlgorithm(): String;

  function getFormat(): String;

  function getEncoded(): String;
}
