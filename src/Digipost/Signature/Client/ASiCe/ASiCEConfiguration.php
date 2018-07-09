<?php

namespace Digipost\Signature\Client\ASiCe;

interface ASiCEConfiguration {

  function getKeyStoreConfig();

  function getGlobalSender();

  function getDocumentBundleProcessors();

  function getClock();
}

