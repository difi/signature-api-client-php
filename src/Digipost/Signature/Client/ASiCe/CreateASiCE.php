<?php

namespace Digipost\Signature\Client\ASiCe;

use Digipost\Signature\Client\ASiCe\Archive\CreateZip;
use Digipost\Signature\Client\ASiCe\Manifest\ManifestCreator;
use Digipost\Signature\Client\ASiCe\Signature\CreateSignature;
use Digipost\Signature\Client\Core\Exceptions\SenderNotSpecifiedException;
use Digipost\Signature\Client\Core\SignatureJob;
use GoetasWebservices\XML\XSDReader\Schema\Exception\SchemaException;
use function GuzzleHttp\Psr7\stream_for;

/**
 * Class CreateASiCE
 *
 * @package Digipost\Signature\Client\ASiCe
 */
class CreateASiCE {

  private $createZip;

  private $createSignature;

  private $manifestCreator;

  private $globalSender;

  private $keyStoreConfig;

  private $documentBundleProcessors;

  public function __construct(
    ManifestCreator $manifestCreator,
    ASiCEConfiguration $clientConfiguration
  ) {
    $this->manifestCreator = $manifestCreator;
    $this->globalSender = $clientConfiguration->getGlobalSender();
    $this->keyStoreConfig = $clientConfiguration->getKeyStoreConfig();
    $this->documentBundleProcessors = $clientConfiguration->getDocumentBundleProcessors(
    );
    $this->createSignature = new CreateSignature(
      $clientConfiguration->getClock()
    );
    $this->createZip = new CreateZip();
  }

  /**
   * @param SignatureJob $job
   *
   * @return DocumentBundle
   * @throws SchemaException
   */
  public function createASiCE(SignatureJob $job) {
    $sender = $job->getSender();
    if (!isset($sender)) {
      $sender = $this->globalSender;
    }
    if (!isset($sender)) {
      throw new SenderNotSpecifiedException();
    }

    $manifest = $this->manifestCreator->createManifest($job, $sender);

    $files = [];
    array_push($files, $job->getDocument());
    array_push($files, $manifest);

    $signature = $this->createSignature->createSignature(
      $files,
      $this->keyStoreConfig
    );
    array_push($files, $signature);
    $zipped = $this->createZip->zipIt($files);
    foreach ($this->documentBundleProcessors as $processor) {
      /** @var DocumentBundleProcessor $processor */
      try {
        $zipStream = stream_for($zipped);
        $processor->process($job, $zipStream);
      } catch (\RuntimeException $e) {
        throw new \RuntimeException($e);
      }
    }

    return new DocumentBundle($zipped);
  }

}
