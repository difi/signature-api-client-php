<?php

namespace DigipostSignatureBundle\Command;

use DigipostSignatureBundle\Loader\YamlFileLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class DigipostGenerateFromXsdCommand extends ContainerAwareCommand {

  /**
   * @inheritdoc
   */
  protected function configure() {
    $defaults = [
      'config' => 'config/xsd2php.yml',
      'src' => [
        'vendor/digipost/signature-api-specification/schema/xsd/thirdparty/XAdES.xsd',
        'vendor/digipost/signature-api-specification/schema/xsd/thirdparty/ts_102918v010201.xsd',
        'vendor/digipost/signature-api-specification/schema/xsd/thirdparty/xmldsig-core-schema.xsd',
        'vendor/digipost/signature-api-specification/schema/xsd/common.xsd',
        'vendor/digipost/signature-api-specification/schema/xsd/direct-and-portal.xsd',
      ],
    ];
    $this
      ->setName('digipost:generate-from-xsd')
      ->setDescription(
        'Generates JMS metadata files and PHP classes from Digipost`s official XSD schemas.'
      )
      ->addArgument(
        'config',
        InputArgument::OPTIONAL,
        'xsd2php configuration file',
        $defaults['config']
      )
      ->addArgument(
        'src',
        InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
        'xsd source file(s)',
        $defaults['src']
      );
  }

  /**
   * @inheritdoc
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->getContainer()
         ->set(
           'logger',
           new \Symfony\Component\Console\Logger\ConsoleLogger($output)
         );

    $this->loadConfigurations($input->getArgument('config'));
    $src = $input->getArgument('src');

    $schemas = [];
    $reader = $this->getContainer()
                   ->get('goetas_webservices.xsd2php.schema_reader');
    foreach ($src as $file) {
      $schemas[] = $reader->readFile($file);
    }

    foreach (['php', 'jms'] as $type) {
      $converter = $this->getContainer()
                        ->get('goetas_webservices.xsd2php.converter.' . $type);
      $items = $converter->convert($schemas);

      $writer = $this->getContainer()
                     ->get('goetas_webservices.xsd2php.writer.' . $type);
      $writer->write($items);
    }

    $output->writeln('Done.');
  }

  /**
   * @param string $configFile
   */
  protected function loadConfigurations($configFile) {
    $locator = new FileLocator('.');
    $yaml = new YamlFileLoader($locator);
    //$xml = new XmlFileLoader($this->containerBuilder, $locator);

    $delegatingLoader = new DelegatingLoader(
      new LoaderResolver(
        [
          $yaml,
          //$xml,
        ]
      )
    );
    try {
      $delegatingLoader->load($configFile);
    } catch (\Exception $e) {
    }
  }
}
