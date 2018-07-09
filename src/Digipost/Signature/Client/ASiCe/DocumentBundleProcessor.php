<?php

namespace Digipost\Signature\Client\ASiCe;

use Digipost\Signature\Client\Core\SignatureJob;

interface DocumentBundleProcessor {

  function process(SignatureJob $job, $documentBundleStream);
}

