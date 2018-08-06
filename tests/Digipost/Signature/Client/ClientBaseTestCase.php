<?php

namespace Tests\DigipostSignatureBundle\Client;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ClientBaseTestCase extends KernelTestCase {

  /** @var \Symfony\Component\HttpKernel\Kernel */
  static $kernel;

  /** @var \Symfony\Component\DependencyInjection\ContainerInterface */
  static $container;

  /** @var String */
  static $dumpFolder;

  /** @var String */
  static $resourcesFolder;

  protected function setUp() {
    parent::setUp();

    $options = [];
    static::$kernel = static::createKernel($options);
    static::$kernel->boot();
    static::$container = static::$kernel->getContainer();

    static::$container->get('digipost_signature.xml_marshaller');

    $root_path = $this->getContainer()->getParameter('kernel.project_dir');
    self::$dumpFolder = $root_path . '/var/data';

    self::$resourcesFolder = $root_path . '/tests/Resources';
  }

  protected function getKernel() {
    return static::$kernel;
  }

  protected function getContainer() {
    return static::$container;
  }
}