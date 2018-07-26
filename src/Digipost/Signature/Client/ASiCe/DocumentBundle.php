<?php
namespace Digipost\Signature\Client\ASiCe;

use function GuzzleHttp\Psr7\stream_for;

class DocumentBundle {

  /**
   * @var String
   */
  private $bytes;

  public function __construct(String $bytes) {
    $this->bytes = $bytes;
  }

  public function getInputStream() {
    //return stream_for($this->bytes);
    return $this->bytes;
  }
}
