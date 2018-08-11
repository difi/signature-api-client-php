<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\API\XML\XMLDirectSignatureJobRequest;
use Digipost\Signature\API\XML\XMLDirectSignatureJobResponse;
use Digipost\Signature\API\XML\XMLDirectSignatureJobStatusResponse;
use Digipost\Signature\API\XML\XMLError;
use Digipost\Signature\API\XML\XMLPortalSignatureJobRequest;
use Digipost\Signature\API\XML\XMLPortalSignatureJobResponse;
use Digipost\Signature\API\XML\XMLPortalSignatureJobStatusChangeResponse;
use Digipost\Signature\Client\ASiCe\DocumentBundle;
use Digipost\Signature\Client\Core\DeleteDocumentsUrl;
use Digipost\Signature\Client\Core\Exceptions\BrokerNotAuthorizedException;
use Digipost\Signature\Client\Core\Exceptions\CantQueryStatusException;
use Digipost\Signature\Client\Core\Exceptions\CertificateException;
use Digipost\Signature\Client\Core\Exceptions\DocumentsNotDeletableException;
use Digipost\Signature\Client\Core\Exceptions\InvalidStatusQueryTokenException;
use Digipost\Signature\Client\Core\Exceptions\JobCannotBeCancelledException;
use Digipost\Signature\Client\Core\Exceptions\NotCancellableException;
use Digipost\Signature\Client\Core\Exceptions\SSLHandshakeException;
use Digipost\Signature\Client\Core\Exceptions\TooEagerPollingException;
use Digipost\Signature\Client\Core\Exceptions\UnexpectedResponseException;
use Digipost\Signature\Client\Core\Internal\Http\Custom;
use Digipost\Signature\Client\Core\Internal\Http\MultipartBodyStream;
use Digipost\Signature\Client\Core\Internal\Http\ResponseStatus;
use Digipost\Signature\Client\Core\Internal\Http\SignatureHttpClient;
use Digipost\Signature\Client\Core\Internal\Http\Status;
use Digipost\Signature\Client\Core\Internal\Http\XMLResponseInterface;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Digipost\Signature\Client\Core\Sender;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use PhpOption\Option;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;

const APPLICATION_XML_TYPE = 'application/xml';
const APPLICATION_OCTET_STREAM_TYPE = 'application/octet-stream';

class ClientHelper {

  private static $LOG;

  const NEXT_PERMITTED_POLL_TIME_HEADER = "X-Next-permitted-poll-time";

  const POLLING_QUEUE_QUERY_PARAMETER = "polling_queue";

  /** @var SignatureHttpClient */
  private $httpClient;

  private $globalSender;

  private $clientExceptionMapper;

  public function __construct(
    SignatureHttpClient $httpClient,
    Sender $globalSender,
    LoggerInterface $logger = NULL
  ) {
    $this->httpClient = $httpClient;
    $this->globalSender = $globalSender;
    $this->clientExceptionMapper = new ClientExceptionMapper();
    self::$LOG = $logger;
  }

  public function sendSignatureJobRequest(
    XMLDirectSignatureJobRequest $signatureJobRequest,
    DocumentBundle $documentBundle,
    Sender $sender = NULL
  ) {
    $actualSender = ActualSender::getActualSender($sender, $this->globalSender);

    $signatureJobBodyPart = new BodyPart(
      $signatureJobRequest,
      'application/xml'
    );
    $documentBundleBodyPart = new BodyPart(
      $documentBundle->getInputStream(),
      'application/octet-stream'
    );

    return $this->call(
      function () use (
        $signatureJobBodyPart,
        $documentBundleBodyPart,
        $actualSender
      ) {
        $usingBodyParts = new UsingBodyParts(
          $this, $signatureJobBodyPart,
          $documentBundleBodyPart
        );

        return $usingBodyParts->postAsMultiPart(
          Target::DIRECT()
                ->path($actualSender),
          XMLDirectSignatureJobResponse::class
        );
      }
    );
  }

  /**
   * @param XMLPortalSignatureJobRequest $signatureJobRequest
   * @param DocumentBundle               $documentBundle
   * @param Sender|NULL                  $sender
   *
   * @return XMLPortalSignatureJobResponse
   */
  public function sendPortalSignatureJobRequest(
    XMLPortalSignatureJobRequest $signatureJobRequest,
    DocumentBundle $documentBundle,
    Sender $sender = NULL
  ) {
    $actualSender = ActualSender::getActualSender($sender, $this->globalSender);

    $signatureJobBodyPart = new BodyPart(
      $signatureJobRequest,
      'application/xml'
    );
    $documentBundleBodyPart = new BodyPart(
      $documentBundle->getInputStream(),
      'application/octet-stream'
    );

    return $this->call(
      function () use (
        $signatureJobBodyPart,
        $documentBundleBodyPart,
        $actualSender
      ) {
        $usingBodyParts = new UsingBodyParts(
          $this, $signatureJobBodyPart,
          $documentBundleBodyPart
        );

        return $usingBodyParts->postAsMultiPart(
          Target::PORTAL()
                ->path($actualSender),
          XMLPortalSignatureJobResponse::class
        );
      }
    );
  }

  public function sendSignatureJobStatusRequest(String $statusUrl) {
    return $this->call(
      function () use ($statusUrl) {
        /** @var XMLResponseInterface|ResponseInterface $response */
        $response = $this->httpClient->target($statusUrl)
          ->request('GET', $statusUrl, [
            'headers' => [
              'Accept' => 'application/xml',
            ],
          ]);
        try {
          $status = ResponseStatus::resolve($response->getStatusCode());

          if (ResponseStatus::equals($status, Status::OK())) {
              return $response->readEntity(XMLDirectSignatureJobStatusResponse::class);
          } else if (ResponseStatus::equals($status, Status::FORBIDDEN())) {
              $error = $this->extractError($response);
              if (ErrorCodes::INVALID_STATUS_QUERY_TOKEN()->sameAs($error->getErrorCode())) {
                  throw new InvalidStatusQueryTokenException($statusUrl, $error->getErrorMessage());
              }
          } else if (ResponseStatus::equals($status, Status::NOT_FOUND())) {
              $error = $this->extractError($response);
              if (ErrorCodes::SIGNING_CEREMONY_NOT_COMPLETED()->sameAs($error->getErrorCode())) {
                  throw new CantQueryStatusException($status, $error->getErrorMessage());
              }
          }
        } catch (\Exception $e) {
          throw $e;
        }
        throw $this->exceptionForGeneralError($response);
      }
    );
  }

  /**
   * @param String $uri
   *
   * @return mixed
   */
  public function getSignedDocumentStream(String $uri) {
    return $this->call(function() use ($uri) {
      return $this->parseResponse($this->httpClient->target($uri)->get($uri, [
        RequestOptions::HEADERS => [
          'Accept' => [APPLICATION_XML_TYPE, APPLICATION_OCTET_STREAM_TYPE],
        ],
        RequestOptions::STREAM => TRUE,
      ]), \GuzzleHttp\Psr7\Stream::class);
    });
  }

  public function getHttpClient() {
    return $this->httpClient;
  }

  public function cancel(Cancellable $cancellable) {
    return $this->call(
      function () use ($cancellable) {
        if ($cancellable->getCancellationUrl() !== NULL) {
          $url = $cancellable->getCancellationUrl()->getUrl();
          try {
            $response = $this->postEmptyEntity($url);
            $status = ResponseStatus::resolve($response->getStatusCode());
            if (ResponseStatus::equals($status, Status::OK())) {
              return;
            } else if (ResponseStatus::equals($status, Status::CONFLICT())) {
              $error = $this->extractError($response);
              throw new JobCannotBeCancelledException($status, $error->getErrorCode(), $error->getErrorMessage());
            }
            throw $this->exceptionForGeneralError($response);
          } catch (\Exception $e) {
            throw $e;
          }
        } else {
          throw new NotCancellableException();
        }
      }
    );
  }

  public function getPortalStatusChange(Sender $sender) {
    return $this->getStatusChange(
      $sender, Target::PORTAL(),
      XMLPortalSignatureJobStatusChangeResponse::class
    );
  }

  public function getDirectStatusChange(Sender $sender) {
    return $this->getStatusChange(
      $sender, Target::DIRECT(),
      XMLDirectSignatureJobStatusResponse::class
    );
  }

  /**
   * @param Sender $sender
   * @param Target $target
   * @param        $responseClass
   *
   * @return mixed
   */
  private function getStatusChange(
    Sender $sender,
    Target $target,
    $responseClass
  ) {
    return $this->call(
      function () use ($responseClass, $target, $sender) {
        $actualSender = ActualSender::getActualSender($sender, $this->globalSender);
        try {
          /** @var Response|XMLResponseInterface $response */
          $response = $this->httpClient->signatureServiceRoot()
            ->request('get', $target->path($actualSender), [
              RequestOptions::HEADERS => [
                'Accept' => APPLICATION_XML_TYPE,
              ],
              RequestOptions::QUERY => [
                self::POLLING_QUEUE_QUERY_PARAMETER => $actualSender->getPollingQueue()->value,
              ],
            ]);

          $status = ResponseStatus::resolve($response->getStatusCode());
          if (ResponseStatus::equals($status, Status::NO_CONTENT())) {
            return new JobStatusResponse(NULL, $this->getNextPermittedPollTime($response));
          }
          else {
            if (ResponseStatus::equals($status, Status::OK())) {
              return new JobStatusResponse(
                $response->readEntity($responseClass),
                $this->getNextPermittedPollTime($response)
              );
            }
            else {
              if (ResponseStatus::equals($status, Custom::TOO_MANY_REQUESTS())) {
                throw new TooEagerPollingException();
              } else {
                throw $this->exceptionForGeneralError($response);
              }
            }
          }
        } catch (\Exception $e) {
          throw $e;
        }
      }
    );
  }

  private static function getNextPermittedPollTime(Response $response) {
    return new \DateTime(
      $response->getHeaderLine(self::NEXT_PERMITTED_POLL_TIME_HEADER)
    );
  }

  public function confirm(Confirmable $confirmable) {
    $this->call(function() use ($confirmable) {
      if ($confirmable->getConfirmationReference() !== null) {
          $url = $confirmable->getConfirmationReference()->getConfirmationUrl();
          self::$LOG->info("{Sends confirmation for '{confirmable}' to URL {url}}", ['confirmable' => $confirmable, 'url' => $url]);
          try {
            $response = $this->postEmptyEntity($url);
            $status = ResponseStatus::resolve($response->getStatusCode());
              if (!ResponseStatus::equals($status, Status::OK())) {
                  throw $this->exceptionForGeneralError($response);
              }
          } catch (\Exception $e) {
            throw $e;
          }
      } else {
          self::$LOG->info("{Does not need to send confirmation for '{confirmable}'}", ['confirmable' => $confirmable]);
      }
    });
  }

  private function call(callable $action) {
    return $this->clientExceptionMapper->doWithMappedClientException($action);
  }

  public function deleteDocuments(DeleteDocumentsUrl $deleteDocumentsUrl) {
    $this->call(
      function () use ($deleteDocumentsUrl) {
        if ($deleteDocumentsUrl !== NULL) {
          $url = $deleteDocumentsUrl->getUrl();
          try {
            $response = $this->delete($url);
            $status = ResponseStatus::resolve($response->getStatusCode());
            if (ResponseStatus::equals($status, Status::OK())) {
              return;
            }
            throw $this->exceptionForGeneralError($response);
          } catch (\Exception $e) {
          }
        }
        else {
          throw new DocumentsNotDeletableException();
        }
      }
    );
  }

  /**
   * @param String $uri
   *
   * @return ResponseInterface|XMLResponseInterface
   * @throws GuzzleException
   */
  private function postEmptyEntity(String $uri) {
    return $this->httpClient->target($uri)
                            ->request('post', $uri, [
                              'headers' => [
                                'Accept' => APPLICATION_XML_TYPE,
                                'Content-Length' => 0,
                              ],
                              'body' => NULL,
                            ]);
  }

  /**
   * @param String $uri
   *
   * @return ResponseInterface|XMLResponseInterface
   * @throws GuzzleException
   */
  private function delete(String $uri) {
    return $this->httpClient->target($uri)
                            ->request('delete', $uri, [
                              'headers' => [
                                'Accept' => APPLICATION_XML_TYPE,
                              ],
                            ]);
  }

  /**
   * @param ResponseInterface $response
   * @param                   $responseType
   *
   * @return StreamInterface|Http\XMLResponse|String
   */
  public function parseResponse(ResponseInterface $response, $responseType) {
    $status = ResponseStatus::resolve($response->getStatusCode());
    if (ResponseStatus::equals($status, Status::OK())) {
      $contentType = $response->getHeader('Content-Type');
      if ($responseType === \GuzzleHttp\Psr7\Stream::class) {
        return $response->getBody();
      } else if ($response instanceof XMLResponseInterface) {
        return $response->readEntity($responseType);
      } else {
        return $response->getBody()->getContents();
      }
    }
    else {
      return $this->exceptionForGeneralError($response);
    }
  }

  private function exceptionForGeneralError(ResponseInterface $response) {
    $error = $this::extractError($response);
    $cause = NULL;

    if (ErrorCodes::BROKER_NOT_AUTHORIZED()->sameAs($error->getErrorCode())) {
      return new BrokerNotAuthorizedException($error);
    }

    return new UnexpectedResponseException(
      $error,
      $cause,
      ResponseStatus::resolve($response->getStatusCode()), Status::OK()
    );
  }

  /**
   * @param ResponseInterface $response
   *
   * @return XMLError
   */
  private static function extractError(ResponseInterface $response): XMLError {
    /** @var XMLError $error */
    $error = NULL;

    $responseContentType = Option::fromValue(
      $response->getHeaderLine('Content-Type')
    );

    if (!$responseContentType->isEmpty()
      && $responseContentType->get() === 'application/xml'
      && $response instanceof XMLResponseInterface) {
      try {
        if ($response->getBody()->isSeekable()) {
          $response->getBody()->rewind();
        }
        $error = $response->readEntity(XMLError::class);
      } catch (\Exception $e) {
        throw new UnexpectedResponseException(
          "Content-Type " . $responseContentType->getOrElse("unknown") . ": " .
          Option::fromValue(get_class($error))->getOrElse(
            /** @lang text */
            "<no content in response>"
          ),
          $e, ResponseStatus::resolve($response->getStatusCode()), Status::OK()
        );
      }
    }
    else {
      throw new UnexpectedResponseException(
        "Content-Type " . $responseContentType->getOrElse("unknown") . ": " .
        Option::fromValue(get_class($error))->getOrElse(
          /** @lang text */
          "<no content in response>"
        ),
        NULL, ResponseStatus::resolve($response->getStatusCode()), Status::OK()
      );
    }
    if ($error === NULL) {
      throw new UnexpectedResponseException(
        NULL, NULL,
        ResponseStatus::resolve($response->getStatusCode()), Status::OK()
      );
    }

    return $error;
  }

  public static function factory(SignatureHttpClient $httpClient, Sender $globalSender, LoggerInterface $logger = NULL) {
    $self = new ClientHelper($httpClient, $globalSender, $logger);
    return $self;
  }

  public function setLogger(LoggerInterface $logger = NULL) {
    if (isset($logger)) {
      self::$LOG = $logger;
    }
  }
}

class BodyPart {

  private $entity;

  private $mediaType;

  private $size;

  public function __construct($entity, $mediaType) {
    if (isset($entity) && !is_string($entity)) {
      /** @var \DOMDocument $contents */
      Marshalling::marshal($entity, $contents, NULL, ['snake-case' => TRUE]);
      $contents->xmlStandalone = TRUE;
      $this->entity = $contents->saveXML();
    }
    else {
      $this->entity = $entity;
    }
    $this->mediaType = $mediaType;
    $this->size = is_string($this->entity) ? mb_strlen($this->entity) : NULL;
  }

  public function toArray() {
    return [
      //'name' => 'ID_' . hash('sha1', $this->entity),
      //'name' => '',
      'contents' => $this->entity,
      //'filename' => $this->get
      'headers' => [
        'Content-Type' => $this->mediaType,
        //  'Content-Disposition' => '',
      ],
    ];
  }

  public function getMediaType() {
    return $this->mediaType;
  }

  public function getSize() {
    return $this->size;
  }
}

class MultiPart extends BodyPart {

  /**
   * @var BodyPart[]
   */
  private $bodyParts = [];

  function __construct($entity = NULL, $mediaType = 'multipart/mixed') {
    parent::__construct($entity, $mediaType);
  }

  function bodyPart($bodyPart) {
    $this->bodyParts[] = $bodyPart;
  }

  function toArray() {
    $ret = [];
    foreach ($this->bodyParts as $x => $bodyPart) {
      //$key = "ID_$x";
      $ret[] = $bodyPart->toArray();
    }

    return $ret;
  }
}

/**
 * Class SignatureRequestStream
 *
 * @package Digipost\Signature\Client\Core\Internal
 * @inheritdoc
 */
//class SignatureRequestStream extends MultipartStream {
//
//  private $boundary;
//
//  public function __construct(array $elements = [], $boundary = NULL) {
//    //parent::__construct($elements, $boundary);
//    if (!isset($boundary)) {
//      $boundary = "Bøøoundary_" . sha1(uniqid('', true));
//    }
//    $this->boundary = $boundary;
//    $this->stream = $this->createStream($elements);
//    /*
//    if (!isset($boundary)) {
//      $boundary = 'Boundary_';
//      $boundary .= sha1(uniqid('', TRUE));
//    }
//    $hore = $elements;
//    */
//    //$test = $this->getBoundary();
//  }
//
//  public function createStream(array $elements)
//  {
//    $stream = new AppendStream();
//
//    foreach ($elements as $element) {
//      $this->addElement($stream, $element);
//    }
//
//    // Add the trailing boundary with CRLF
//    $stream->addStream(stream_for("--{$this->boundary}--\r\n"));
//
//    return $stream;
//  }
//
//  private function addElement(AppendStream $stream, array $element)
//  {
//    foreach (['contents'] as $key) {
//      if (!array_key_exists($key, $element)) {
//        throw new \InvalidArgumentException("A '{$key}' key is required");
//      }
//    }
//
//    $element['contents'] = stream_for($element['contents']);
//
//    if (empty($element['filename'])) {
////      $uri = $element['contents']->getMetadata('uri');
////      if (substr($uri, 0, 6) !== 'php://') {
////        $element['filename'] = $uri;
////      }
//    }
//
//    list($body, $headers) = $this->createElement(
//      isset($element['name']) ? $element['name'] : NULL,
//      $element['contents'],
//      isset($element['filename']) ? $element['filename'] : null,
//      isset($element['headers']) ? $element['headers'] : []
//    );
//
//    $stream->addStream(stream_for($this->getHeaders($headers)));
//    $stream->addStream($body);
//    $stream->addStream(stream_for("\r\n"));
//  }
//
//  private function createElement($name, StreamInterface $stream, $filename,
//                                 array $headers) {
//    // Set a default content-disposition header if one was no provided
//    //$disposition = $this->getHeader($headers, 'content-disposition');
//    //if (!$disposition) {
////      $headers['Content-Disposition'] = ($filename === '0' || $filename)
////        ? sprintf('form-data; name="%s"; filename="%s"',
////                  $name,
////                  basename($filename))
////        : "form-data; name=\"{$name}\"";
//    //}
//
//    // Set a default content-length header if one was no provided
//    //$length = $this->getHeader($headers, 'content-length');
//    //if (!$length) {
////      if ($length = $stream->getSize()) {
////        $headers['Content-Length'] = (string) $length;
////      }
//    //}
//
//    // Set a default Content-Type if one was not supplied
//    $type = $this->getHeader($headers, 'content-type');
//    if (!$type && ($filename === '0' || $filename)) {
//      if ($type = mimetype_from_filename($filename)) {
//        $headers['Content-Type'] = $type;
//      }
//    }
//
//    return [$stream, $headers];
//  }
//
//  private function getHeader(array $headers, $key)
//  {
//    $lowercaseHeader = strtolower($key);
//    foreach ($headers as $k => $v) {
//      if (strtolower($k) === $lowercaseHeader) {
//        return $v;
//      }
//    }
//
//    return null;
//  }
//}

class UsingBodyParts {

  private $parts;

  private $parent;

  function __construct(ClientHelper $clientHelper, BodyPart... $parts) {
    $this->parent = $clientHelper;
    $this->parts = is_array($parts) ? $parts : [$parts];
  }

  /**
   * @param String $path
   * @param String $responseType
   *
   * @return BrokerNotAuthorizedException|UnexpectedResponseException|string
   * @throws \Exception
   */
  function postAsMultiPart(String $path, $responseType) {
    try {
      $multiPart = new MultiPart();
      foreach ($this->parts as $bodyPart) {
        $multiPart->bodyPart($bodyPart);
      }
      $path = substr($path, 1);

      try {
        $client = $this->parent->getHttpClient()->signatureServiceRoot();

        $body = new MultipartBodyStream($multiPart->toArray());
        $response = $client
          ->post(
            $path,
            [
              'headers' => [
                'Content-Type' => $multiPart->getMediaType() .
                  '; boundary=' . $body->getBoundary(),
                'Accept' => 'application/xml',
              ],
              'body' => $body,
              'allow_redirects' => FALSE,
            ]
          );

        return $this->parent->parseResponse($response, $responseType);
      } catch (ClientException $e) {
        throw new \RuntimeException("Something went wrong", 0, $e);
      }
    } catch (ConnectException $e) {
      $handler = $e->getHandlerContext();
      if ($handler && $handler['errno']) {
        switch ($handler['errno']) {
          case CURLE_SSL_CERTPROBLEM:
            throw new CertificateException(
              "Problem with the local client certificate.", $e
            );
          case CURLE_SSL_CONNECT_ERROR:
            throw new SSLHandshakeException(
              "A problem occurred somewhere in the SSL/TLS handshake.",
              $handler['errno'], $e
            );
        }
      }
      throw $e;
    } catch (UnexpectedResponseException $e) {
      throw $e;
    } catch (\InvalidArgumentException $e) {
      throw $e;
    } catch (\Exception $e) {
      //dump($e->getTraceAsString());
      throw $e;
      //      throw new RuntimeIOException(
      //        get_class($e) . ": " . $e->getMessage(), $e
      //      );
    }
  }
}