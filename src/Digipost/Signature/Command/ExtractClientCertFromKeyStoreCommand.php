<?php

namespace DigipostSignatureBundle\Command;

use Sop\CryptoEncoding\PEM;
use Sop\CryptoEncoding\PEMBundle;
use Sop\CryptoTypes\Asymmetric\RSA\RSAPrivateKey;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use X509\Certificate\CertificateChain;

class ExtractClientCertFromKeyStoreCommand extends ContainerAwareCommand {

  /**
   * @inheritdoc
   */
  protected function configure() {
    $this
      ->setName('digipost:extract-from-keystore')
      ->setDescription(
        'Extracts client certificate and private key from the configured keystore.'
      )
      ->addOption('force', 'f', InputOption::VALUE_NONE, 'Overwrite existing files');
  }

  /**
   * @inheritdoc
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $c = $this->getContainer();
    $keyStoreConfig = $c->get('digipost_signature.keystore_config');
    $key_passphrase = $c->getParameter('digipost_signature.keystore.key.password');

    $root_dir = $c->getParameter('kernel.project_dir') . '/';
    $file_privateKey = $c->getParameter('digipost_signature.keystore.client_key');
    $file_cert = $c->getParameter('digipost_signature.keystore.client_cert');
    $overwrite = $input->getOption('force');

    if ((file_exists($file_privateKey) || file_exists($file_cert)) && !$overwrite) {
      foreach ([$file_privateKey, $file_cert] as $f) {
        if (!file_exists($f)) {
          continue;
        }
        throw new FileException(
          sprintf('File "%s" already exists. Use %s option to overwrite', str_replace($root_dir, '', $f), 'force')
        );
      }
    }
    if (!is_writable($file_privateKey) || !is_writable($file_cert)) {
      foreach ([$file_privateKey, $file_cert] as $f) {
        if (is_writable($f)) {
          continue;
        }
        throw new FileException(sprintf('Unable to write to file "%s".', str_replace($root_dir, '', $f)));
      }
    }
    $clientKey = RSAPrivateKey::fromPEM(
      PEM::fromString($keyStoreConfig->getPrivateKey()->getEncoded($key_passphrase))
    )->toPEM()->string() . "\n";

    $clientCert = [];
    /** @var \Digipost\Signature\Client\Core\Internal\Security\X509Certificate $c */
    foreach ($keyStoreConfig->getCertificateChain() as $c) {
      $clientCert[] = PEM::fromString($c->getClearText());
    }
    $chain = CertificateChain::fromPEMs(...$clientCert);
    $clientCertString = $chain->toPEMString();
    file_put_contents($file_privateKey, $clientKey);
    $output->writeln(sprintf("Successfully wrote client key (%d bytes) to %s", mb_strlen($clientKey), str_replace($root_dir, '', $file_privateKey)));

    file_put_contents($file_cert, $clientCertString);
    $output->writeln(sprintf("Successfully wrote client certificate (%d bytes) to %s", mb_strlen($clientCertString), str_replace($root_dir, '', $file_cert)));
  }
}
