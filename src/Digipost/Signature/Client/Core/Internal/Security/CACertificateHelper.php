<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

use Psr\Container\ContainerInterface;

class CACertificateHelper {

  private $container;

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }
}