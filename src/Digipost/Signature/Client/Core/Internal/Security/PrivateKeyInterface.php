<?php
namespace Digipost\Signature\Client\Core\Internal\Security;

interface PrivateKeyInterface extends \Serializable {
  function getAlgorithm();

  function getFormat();

  function getEncoded();
}
