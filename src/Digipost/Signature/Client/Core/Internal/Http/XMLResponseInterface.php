<?php
namespace Digipost\Signature\Client\Core\Internal\Http;

use Psr\Http\Message\ResponseInterface;

interface XMLResponseInterface extends ResponseInterface {

  public function readEntity(String $entityType);
}