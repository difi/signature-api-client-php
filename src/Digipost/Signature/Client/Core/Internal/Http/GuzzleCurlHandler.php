<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use GuzzleHttp\Handler\CurlFactory;
use GuzzleHttp\Handler\CurlFactoryInterface;
use Psr\Http\Message\RequestInterface;

class GuzzleCurlHandler {

  /**
   * @var CurlFactoryInterface
   */
  private $factory;

  /**
   * @var array
   */
  private $options;

  public function __construct(array $options = [])
  {
    $this->factory = isset($options['handle_factory'])
      ? $options['handle_factory']
      : new CurlFactory(3);
    $this->options = $options;
  }

  public function __invoke(RequestInterface $request, array $options) {
    if (isset($options['delay'])) {
      usleep($options['delay'] * 1000);
    }

    $easy = $this->factory->create($request, $options);
    curl_setopt($easy->handle, CURLOPT_CERTINFO, TRUE);
    curl_setopt($easy->handle, CURLOPT_SSL_VERIFYHOST, 0);
    curl_exec($easy->handle);
    $easy->errno = curl_errno($easy->handle);

    return CurlFactory::finish($this, $easy, $this->factory);
  }
}
