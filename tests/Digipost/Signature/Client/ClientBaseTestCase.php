<?php

namespace Tests\DigipostSignatureBundle\Client;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ClientBaseTestCase extends KernelTestCase {

  /** @var \Symfony\Component\HttpKernel\Kernel */
  static $kernel;

  /** @var \Symfony\Component\DependencyInjection\ContainerInterface */
  static $container;

  static $dumpFolder;

  protected function setUp() {
    parent::setUp();

    $options = [];
    static::$kernel = static::createKernel($options);
    static::$kernel->boot();
    static::$container = static::$kernel->getContainer();

    static::$container->get(
      'Digipost\Signature\Client\Core\Internal\XML\Marshalling'
    );

    $root_path = $this->getContainer()->getParameter('kernel.project_dir');
    self::$dumpFolder = $root_path . '/var/data';
  }

  protected function getKernel() {
    return static::$kernel;
  }

  protected function getContainer() {
    return static::$container;
  }
}