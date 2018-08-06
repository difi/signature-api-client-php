<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class XMLResponse extends \GuzzleHttp\Psr7\Response implements XMLResponseInterface {
  /** @var StreamInterface */
  private $stream;

  /** @var Object */
  private $entity;

  /**
   * @param ResponseInterface $response
   *
   * @return XMLResponse
   */
  public static function fromResponse(ResponseInterface $response) {
    return new XMLResponse(
      $response->getStatusCode(), $response->getHeaders(), $response->getBody(),
      $response->getProtocolVersion(), $response->getReasonPhrase()
    );
  }

  public function readEntity(String $entityType) {
    if ($entityType === \GuzzleHttp\Psr7\Stream::class) {
      return $this->getBody();
    }
    $params = [];
    $this->entity = Marshalling::unmarshal($this->getBody()->getContents(), $entityType, $params);

    return $this->entity;
  }

  /**
   * @return \Psr\Http\Message\StreamInterface
   */
  public function getStream() {
    return $this->stream;
  }
}