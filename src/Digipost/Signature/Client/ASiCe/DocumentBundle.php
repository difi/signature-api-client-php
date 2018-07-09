<?php
namespace Digipost\Signature\Client\ASiCe;

class DocumentBundle {

  /**
   * @var String
   */
  private $bytes;

  public function __construct(String $bytes) {
    $this->bytes = $bytes;
  }

  public function getInputStream() {
    return $this->bytes;
    //return \GuzzleHttp\Psr7\stream_for($this->bytes);
  }
}
