<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use function GuzzleHttp\Psr7\stream_for;
use JMS\Serializer\Annotation as Serializer;
use Psr\Http\Message\StreamInterface;

abstract class XMLStream implements StreamInterface {

  /**
   * @var StreamInterface
   * @Serializer\Exclude()
   */
  private $stream;

  /**
   * @inheritdoc
   */
  public function __toString() {
    $this->marshal();
    return $this->stream->__toString();
  }

  /**
   * @inheritdoc
   */
  public function close() {
    $this->stream->close();
  }

  /**
   * @inheritdoc
   */
  public function detach() {
    return $this->stream->detach();
  }

  /**
   * @inheritdoc
   */
  public function getSize() {
    return $this->stream->getSize();
  }

  /**
   * @inheritdoc
   */
  public function tell() {
    return $this->stream->tell();
  }

  /**
   * @inheritdoc
   */
  public function eof() {
    return $this->stream->eof();
  }

  /**
   * @inheritdoc
   */
  public function isSeekable() {
    return $this->stream->isSeekable();
  }

  /**
   * @inheritdoc
   */
  public function seek($offset, $whence = SEEK_SET) {
    return $this->stream->seek($offset, $whence);
  }

  /**
   * @inheritdoc
   */
  public function rewind() {
    return $this->stream->rewind();
  }

  /**
   * @inheritdoc
   */
  public function isWritable() {
    return $this->stream->isWritable();
  }

  /**
   * @inheritdoc
   */
  public function write($string) {
    return $this->stream->write($string);
  }

  /**
   * @inheritdoc
   */
  public function isReadable() {
    return $this->stream->isReadable();
  }

  /**
   * @inheritdoc
   */
  public function read($length) {
    return $this->stream->read($length);
  }

  /**
   * @inheritdoc
   */
  public function getContents() {
    if (!$this->stream) {
      $this->marshal();
    }
    return $this->stream->getContents();
  }

  /**
   * @inheritdoc
   */
  public function getMetadata($key = NULL) {
    return $this->stream->getMetadata($key);
  }

  protected function marshal() {
    /** @var \DOMDocument $domOutput */
    Marshalling::marshal($this, $domOutput, NULL, ['snake-case' => TRUE]);
    $this->setStream(stream_for($domOutput->saveXML()));
  }

  /**
   * @param StreamInterface $stream
   *
   * @return XMLStream
   */
  private function setStream(StreamInterface $stream) {
    $this->stream = $stream;
    return $this;
  }

  /**
   * @return XMLStream
   */
  public function getStream() {
    $this->marshal();
    return $this;
  }
}