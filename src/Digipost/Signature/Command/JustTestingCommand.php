<?php

namespace DigipostSignatureBundle\Command;

use Digipost\Signature\API\XML\XMLError;
use Digipost\Signature\Client\Certificates;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class JustTestingCommand extends ContainerAwareCommand {

  /**
   * @inheritdoc
   */
  protected function configure() {
    $this
      ->setName('digipost:testing')
      ->setDescription(
        '....'
      );
  }

  /**
   * @inheritdoc
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $keyStore = $this->getContainer()->get(
      'digipost_signature.keystore_config'
    );
    $this->getContainer()->get('Digipost\Signature\Client\Certificates');

    //Marshalling::marshal($object)
    $object = new XMLError(
      'ASICE_VALIDATION_FAILED',
      'Error when validating ASiCE: Parse error: Failed to parse XMLDirectSignatureJobManifest',
      'CLIENT'
    );

    $this->getContainer()->get(
      'Digipost\Signature\Client\Core\Internal\XML\Marshalling'
    );

    $xml = Marshalling::marshal($object, $outputXML);
    //$marshalling->_marshal($object, $outputXML);

    /** @var \DOMDocument $outputXML */
    $outputXML->formatOutput = FALSE;
    print $outputXML->saveXML();

    //$this->getContainer()->get('Digipost\Signature\Client\Certificates')::PRODUCTION();
    $certificates = Certificates::PRODUCTION();

    $output->writeln('Helelooee.');
  }
}
