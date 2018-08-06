<?php
namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Portal\CancellationUrl;

interface Cancellable {

  function getCancellationUrl(): CancellationUrl;
}

