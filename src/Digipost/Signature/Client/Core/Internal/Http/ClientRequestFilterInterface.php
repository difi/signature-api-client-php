<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 06.08.18
 * Time: 03:33
 */

namespace Digipost\Signature\Client\Core\Internal\Http;

use Psr\Http\Message\RequestInterface;

interface ClientRequestFilterInterface {

  public function filter(RequestInterface $request): RequestInterface;
}