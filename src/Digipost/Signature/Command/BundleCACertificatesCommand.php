<?php

namespace DigipostSignatureBundle\Command;

use Digipost\Signature\Client\Certificates;
use DigipostSignatureBundle\Loader\YamlFileLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOException;


class BundleCACertificatesCommand extends ContainerAwareCommand {

  /**
   * @inheritdoc
   */
  protected function configure() {
    $this
      ->setName('digipost:compile-trust-store')
      ->setDescription(
        'Compiles a bundle of the server certificates we trust.'
      );
  }

  /**
   * @inheritdoc
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $c = $this->getContainer();
    $sources = $c->getParameter('digipost_signature.ca_files.path');
    $dest = $c->getParameter('digipost_signature.ca_bundle.path');
    $root_dir = $c->getParameter('kernel.project_dir');
    $relative_dir = str_replace($root_dir, '', $dest);

    Certificates::build($c, $sources);

    $envs = [
      'test' => Certificates::TEST()->certificatePaths(),
      'prod' => Certificates::PRODUCTION()->certificatePaths(),
    ];

    $bundles = [];
    foreach ($envs as $env => $paths) {
      $certificates = [];
      foreach ($paths as $path) {
        $data = file_get_contents($path);
        $certificates[] = self::encodeAndWrapToPEM($data);
      }
      $bundles[$env] = implode('', $certificates);
    }

    foreach (array_keys($bundles) as $env) {
      $dir = "$dest/$env";
      if (!realpath($dest)) {
        throw new IOException('No such file or directory: ' . $dest);
      }
      $filename = 'ca-bundle.pem';
      if (!is_dir($dir) && @!mkdir($dir, 0750, TRUE)) {
        throw new IOException('Unable to create non-existant directory: ".' . $relative_dir . '"');
      }
      if (!is_dir($dir) || !is_writable("$dir/")) {
        throw new IOException('Unable to write to destination directory ".' . $relative_dir . '"');
      }
      file_put_contents("$dir/$filename", $bundles[$env]);
      $output->writeln(sprintf("Wrote %d bytes to .%s/%s/%s", strlen($bundles[$env]), $relative_dir, $env, $filename));
    }

    //$output->write(implode('', $certificates));
    $output->writeln('Done.');
  }

  /**
   * @param $data
   *
   * @return string
   */
  private static function encodeAndWrapToPEM($data) {
    $ascii = base64_encode($data);
    $cert = "-----BEGIN CERTIFICATE-----\n";
    $cert .= wordwrap($ascii, 64, "\n", TRUE);
    $cert .= "\n-----END CERTIFICATE-----\n";
    return $cert;
  }
}
