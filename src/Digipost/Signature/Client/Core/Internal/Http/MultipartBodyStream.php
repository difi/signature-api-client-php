<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use GuzzleHttp\Psr7\AppendStream;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use Psr\Http\Message\StreamInterface;
use function GuzzleHttp\Psr7\mimetype_from_filename;
use function GuzzleHttp\Psr7\stream_for;

/**
 * Stream that when read returns bytes for a streaming multipart or
 * multipart/form-data stream.
 */
class MultipartBodyStream implements StreamInterface {

  use StreamDecoratorTrait;

  static $boundaryCounter = 0;

  public static function boundaryCounterIncrementAndGet() {
    self::$boundaryCounter++;
    return self::$boundaryCounter;
  }

  private $boundary;

  /**
   * @inheritdoc
   */
  public function __construct(array $elements = [], $boundary = NULL) {
    if (!isset($boundary)) {
      $counter = self::boundaryCounterIncrementAndGet();
      $boundary = 'Boundary_' . $counter . '_' . sha1(uniqid('', TRUE));
    }
    $this->boundary = $boundary;
    $this->stream = $this->createStream($elements);
  }

  /**
   * Get the boundary
   *
   * @return string
   */
  public function getBoundary() {
    return $this->boundary;
  }

  public function isWritable() {
    return FALSE;
  }

  /**
   * Get the headers needed before transferring the content of a POST file
   */
  private function getHeaders(array $headers) {
    $str = '';
    foreach ($headers as $key => $value) {
      $str .= "{$key}: {$value}\r\n";
    }

    return "--{$this->boundary}\r\n" . trim($str) . "\r\n\r\n";
  }

  /**
   * Create the aggregate stream that will be used to upload the POST data
   */
  protected function createStream(array $elements) {
    $stream = new AppendStream();

    foreach ($elements as $element) {
      $this->addElement($stream, $element);
    }

    // Add the trailing boundary with CRLF
    $stream->addStream(stream_for("--{$this->boundary}--\r\n"));

    return $stream;
  }

  private function addElement(AppendStream $stream, array $element) {
    foreach (['contents'] as $key) {
      if (!array_key_exists($key, $element)) {
        throw new \InvalidArgumentException("A '{$key}' key is required");
      }
    }

    $element['contents'] = stream_for($element['contents']);
    //    if (empty($element['filename'])) {
    //      $uri = $element['contents']->getMetadata('uri');
    //      if (substr($uri, 0, 6) !== 'php://') {
    //        $element['filename'] = $uri;
    //      }
    //    }

    list($body, $headers) = $this->createElement(
      isset($element['name']) ? $element['name'] : NULL,
      $element['contents'],
      isset($element['filename']) ? $element['filename'] : NULL,
      isset($element['headers']) ? $element['headers'] : []
    );

    $stream->addStream(stream_for($this->getHeaders($headers)));
    $stream->addStream($body);
    $stream->addStream(stream_for("\r\n"));
  }

  /**
   * @return array
   */
  private function createElement($name, StreamInterface $stream, $filename,
                                 array $headers) {
    // Set a default content-disposition header if one was no provided
    //    $disposition = $this->getHeader($headers, 'content-disposition');
    //    if (!$disposition) {
    //      $headers['Content-Disposition'] = ($filename === '0' || $filename)
    //        ? sprintf('form-data; name="%s"; filename="%s"',
    //                  $name,
    //                  basename($filename))
    //        : "form-data; name=\"{$name}\"";
    //    }

    // Set a default content-length header if one was no provided
    $length = $this->getHeader($headers, 'content-length');
    if (!$length) {
      if ($length = $stream->getSize()) {
        $headers['Content-Length'] = (string) $length;
      }
    }

    // Set a default Content-Type if one was not supplied
    $type = $this->getHeader($headers, 'content-type');
    if (!$type && ($filename === '0' || $filename)) {
      if ($type = mimetype_from_filename($filename)) {
        $headers['Content-Type'] = $type;
      }
    }

    return [$stream, $headers];
  }

  private function getHeader(array $headers, $key) {
    $lowercaseHeader = strtolower($key);
    foreach ($headers as $k => $v) {
      if (strtolower($k) === $lowercaseHeader) {
        return $v;
      }
    }

    return NULL;
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
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
    $size = $this->stream->getSize();
    if ($size === NULL) {
      throw new \RuntimeException("Could not determine stream size");
    }
    return $size;
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
    return $this->stream->getContents();
  }

  /**
   * @inheritdoc
   */
  public function getMetadata($key = NULL) {
    return $this->stream->getMetadata($key);
  }
}
