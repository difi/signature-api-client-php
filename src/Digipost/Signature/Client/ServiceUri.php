<?php

namespace Digipost\Signature\Client;

use GuzzleHttp\Psr7\Uri;
use MyCLabs\Enum\Enum;

/**
 * Class ServiceUri
 *
 * @package Digipost\Signature\Client
 *
 * @method static ServiceUri PRODUCTION
 * @method static ServiceUri DIFI_QA
 * @method static ServiceUri DIFI_TEST
 */
class ServiceUri extends Enum {

  const PRODUCTION = "https://api.signering.posten.no/api/";

  const DIFI_QA = "https://api.difiqa.signering.posten.no/api/";

  const DIFI_TEST = "https://api.difitest.signering.posten.no/api/";

  //const DIFI_TEST = "https://de22e73a.ngrok.io/api/";

  protected $uri;

  function __construct($value) {
    parent::__construct($value);
    $this->uri = new Uri($this->value);
  }

  public function uri() {
    return $this->uri;
  }
}

