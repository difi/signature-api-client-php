<?php

namespace Digipost\Signature\Client\ASiCe;

use Digipost\Signature\Client\Core\SignatureJob;
use GuzzleHttp\Psr7\Stream;

interface DocumentBundleProcessor {

  function process(SignatureJob $job, Stream $documentBundleStream);
}

