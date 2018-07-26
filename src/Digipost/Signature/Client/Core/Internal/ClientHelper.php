<?php

namespace Digipost\Signature\Client\Core\Internal;

use Confirmable;
use Digipost\Signature\API\XML\XMLDirectSignatureJobRequest;
use Digipost\Signature\API\XML\XMLDirectSignatureJobResponse;
use Digipost\Signature\API\XML\XMLDirectSignatureJobStatusResponse;
use Digipost\Signature\API\XML\XMLError;
use Digipost\Signature\API\XML\XMLPortalSignatureJobRequest;
use Digipost\Signature\API\XML\XMLPortalSignatureJobStatusChangeResponse;
use Digipost\Signature\Client\ASiCe\DocumentBundle;
use Digipost\Signature\Client\Core\DeleteDocumentsUrl;
use Digipost\Signature\Client\Core\Exceptions\CertificateException;
use Digipost\Signature\Client\Core\Exceptions\DocumentsNotDeletableException;
use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;
use Digipost\Signature\Client\Core\Exceptions\SSLHandshakeException;
use Digipost\Signature\Client\Core\Exceptions\TooEagerPollingException;
use Digipost\Signature\Client\Core\Exceptions\UnexpectedResponseException;
use Digipost\Signature\Client\Core\Internal\Http\MultipartBodyStream;
use Digipost\Signature\Client\Core\Internal\Http\ResponseStatus;
use Digipost\Signature\Client\Core\Internal\Http\SignatureHttpClient;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Digipost\Signature\Client\Core\Sender;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Response;
use PhpOffice\PhpWord\Exception\Exception;

class ClientHelper {

  //private static final Logger LOG = LoggerFactory.getLogger(ClientHelper.class);

  const NEXT_PERMITTED_POLL_TIME_HEADER = "X-Next-permitted-poll-time";

  const POLLING_QUEUE_QUERY_PARAMETER = "polling_queue";

  private $httpClient;

  private $globalSender;

  private $clientExceptionMapper;

  public function __construct(
    SignatureHttpClient $httpClient,
    Sender $globalSender
  ) {
    $this->httpClient = $httpClient;
    $this->globalSender = $globalSender;
    $this->clientExceptionMapper = new ClientExceptionMapper();
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

  public function sendPortalSignatureJobRequest(
    XMLPortalSignatureJobRequest $signatureJobRequest,
    DocumentBundle $documentBundle,
    Sender $sender
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
    //        return call(() -> new UsingBodyParts(signatureJobBodyPart, documentBundleBodyPart)
    //                .postAsMultiPart(PORTAL.path(actualSender), XMLPortalSignatureJobResponse.class));
  }

  public function sendSignatureJobStatusRequest(String $statusUrl) {
    //        return call(() -> {
    //            Invocation.Builder request = httpClient.target(statusUrl).request().accept(APPLICATION_XML_TYPE);
    //
    //            try (Response response = request.get()) {
    //                StatusType status = ResponseStatus.resolve(response.getStatus());
    //                if (status == OK) {
    //                    return response.readEntity(XMLDirectSignatureJobStatusResponse.class);
    //                } else if (status == FORBIDDEN) {
    //                    XMLError error = extractError(response);
    //                    if (ErrorCodes.INVALID_STATUS_QUERY_TOKEN.sameAs(error.getErrorCode())) {
    //                        throw new InvalidStatusQueryTokenException(statusUrl, error.getErrorMessage());
    //                    }
    //                } else if (status == NOT_FOUND) {
    //                    XMLError error = extractError(response);
    //                    if (SIGNING_CEREMONY_NOT_COMPLETED.sameAs(error.getErrorCode())) {
    //                        throw new CantQueryStatusException(status, error.getErrorMessage());
    //                    }
    //                }
    //                throw exceptionForGeneralError(response);
    //            }
    //        });
  }

  public function getSignedDocumentStream(String $uri) {
    //return call(() -> parseResponse(httpClient.target(uri).request().accept(APPLICATION_XML_TYPE, APPLICATION_OCTET_STREAM_TYPE).get(), InputStream.class));
  }

  public function getHttpClient() {
    return $this->httpClient;
  }

  public function cancel(Cancellable $cancellable) {
    //        call(() -> {
    //            if (cancellable.getCancellationUrl() != null) {
    //                String url = cancellable.getCancellationUrl().getUrl();
    //                try (Response response = postEmptyEntity(url)) {
    //                    StatusType status = ResponseStatus.resolve(response.getStatus());
    //                    if (status == OK) {
    //                        return;
    //                    } else if (status == CONFLICT) {
    //                        XMLError error = extractError(response);
    //                        throw new JobCannotBeCancelledException(status, error.getErrorCode(), error.getErrorMessage());
    //                    }
    //                    throw exceptionForGeneralError(response);
    //                }
    //            } else {
    //                throw new NotCancellableException();
    //            }
    //        });
  }

  public function getPortalStatusChange(Sender $sender) {
    return $this->getStatusChange(
      $sender, PORTAL,
      XMLPortalSignatureJobStatusChangeResponse::class
    );
  }

  public function getDirectStatusChange(Sender $sender) {
    return $this->getStatusChange(
      $sender, DIRECT,
      XMLDirectSignatureJobStatusResponse::class
    );
  }

  private function getStatusChange(
    Sender $sender,
    Target $target,
    $responseClass
  ) {
    return $this->call(
      function () use ($responseClass, $target, $sender) {
        $actualSender = $this->getActualSender($sender, $this->globalSender);
        $request = httpClient::signatureServiceRoot()
                             ->path($target->path($actualSender))
                             ->queryParam(
                               self::POLLING_QUEUE_QUERY_PARAMETER,
                               $actualSender->getPollingQueue()->value
                             )
                             ->request()
                             ->accept(APPLICATION_XML_TYPE);
        try {
          $response = $request->get();
          $status = ResponseStatus::resolve($response->getStatus());
          if ($status == NO_CONTENT) {
            return new JobStatusResponse(
              NULL,
              $this->getNextPermittedPollTime($response)
            );
          }
          else {
            if ($status == OK) {
              return new JobStatusResponse(
                $response->readEntity($responseClass),
                $this->getNextPermittedPollTime($response)
              );
            }
            else {
              if ($status == TOO_MANY_REQUESTS) {
                throw new TooEagerPollingException();
              }
              else {
                throw $this->exceptionForGeneralError($response);
              }
            }
          }
        } catch (\Exception $e) {
          return NULL;
        }
      }
    );
  }

  private static function getNextPermittedPollTime(Response $response) {
    //return ZonedDateTime.parse(response.getHeaderString(NEXT_PERMITTED_POLL_TIME_HEADER), ISO_DATE_TIME).toInstant();
    return new \DateTime(
      $response->getHeaderLine(self::NEXT_PERMITTED_POLL_TIME_HEADER)
    );
  }

  public function confirm(Confirmable $confirmable) {
    //        call(() -> {
    //            if (confirmable.getConfirmationReference() != null) {
    //                String url = confirmable.getConfirmationReference().getConfirmationUrl();
    //                LOG.info("Sends confirmation for '{}' to URL {}", confirmable, url);
    //                try (Response response = postEmptyEntity(url)) {
    //                    StatusType status = ResponseStatus.resolve(response.getStatus());
    //                    if (status != OK) {
    //                        throw exceptionForGeneralError(response);
    //                    }
    //                }
    //            } else {
    //                LOG.info("Does not need to send confirmation for '{}'", confirmable);
    //            }
    //        });
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
            if ($status === 200) {
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

  private function postEmptyEntity(String $uri) {
    return $this->httpClient->target($uri)
                            ->request()
                            ->accept(APPLICATION_XML_TYPE)
                            ->header("Content-Length", 0)
                            ->post(Entity::entity(NULL, APPLICATION_XML_TYPE));
  }

  private function delete(String $uri) {
    return $this->httpClient->target($uri)
                            ->request()
                            ->accept(APPLICATION_XML_TYPE)
                            ->delete();
  }

  public function parseResponse(Response $response, $responseType) {
    $status = ResponseStatus::resolve($response->getStatusCode());
    if ($status === 200) {
      return $response->getBody()->getContents();
    }
    else {
      throw $this->exceptionForGeneralError($response);
    }
  }

  private function exceptionForGeneralError(Response $response) {
    $error = $this::extractError($response);
    //        if (BROKER_NOT_AUTHORIZED->sameAs(error.getErrorCode())) {
    //            return new BrokerNotAuthorizedException(error);
    //        }
    return new UnexpectedResponseException(
      $error,
      ResponseStatus::resolve($response->getStatusCode())
    );
  }

  private static function extractError(Response $response) {
    $error = NULL;
    //$responseContentType = $response->getHeaderString(HttpHeaders . CONTENT_TYPE);
    $responseContentType = $response->getHeader('Content-Type');
    if (!empty($responseContentType) && in_array(
        'application/xml',
        $responseContentType
      )) {
      try {
        $errorContents = $response->getBody()->getContents();
        $error = Marshalling::unmarshal(
          $errorContents, XMLError::class, ['snake-case' => TRUE]
        );
        //$error = $response->readEntity(XMLError::class);
      } catch (\Exception $e) {
        throw new UnexpectedResponseException(
          "Content-Type " . implode(
            '][',
            $responseContentType
          ) . ": " . $error, 0, $e
        );

        //          Optional . ofNullable($response->readEntity(String::class))->filter(StringUtils::isNoneBlank) . orElse("<no content in response>"),
        //                            e, ResponseStatus . resolve(response . getStatus()), OK);
      }
    }
    else {
      throw new UnexpectedResponseException(
        "Content-Type " . implode('][', $responseContentType) . ": " .
        $response->getStatusCode()
      );
      //        Optional . ofNullable(response . readEntity(String .class)).filter(StringUtils::isNoneBlank) . orElse("<no content in response>"),
      //                        ResponseStatus . resolve(response . getStatus()), OK);
    }
    if ($error === NULL) {
      throw new UnexpectedResponseException(
        NULL,
        ResponseStatus::resolve($response->getStatusCode())
      );
    }
    return $error;
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

  function postAsMultiPart(String $path, $responseType) {
    try {

      $multiPart = new MultiPart();
      foreach ($this->parts as $bodyPart) {
        $multiPart->bodyPart($bodyPart);
      }
      /*
      $request = httpClient::signatureServiceRoot()->path($path)
        ->request()
        ->header(CONTENT_TYPE, $multiPart->getMediaType())
        ->accept(APPLICATION_XML_TYPE);
      $response = $request->post(Entity::entity($multiPart,
                                                $multiPart->getMediaType()));
      return $this->parseResponse(response, responseType);
      */
      //$test = new $responseType();
      //return $test;
      //print "Path . $path";
      $path = substr($path, 1);

      try {
        $client = $this->parent->getHttpClient()->signatureServiceRoot();
        $body = new MultipartBodyStream($multiPart->toArray());
        $response = $client
          ->post(
            $path, [
            'headers' => [
              'Content-Type' => $multiPart->getMediaType(
                ) . '; boundary=' . $body->getBoundary(),
              //'Content-Length' => $body->getSize(),
              //'Content-Length' => 1914,
              'Accept' => 'application/xml',
            ],
            'body' => $body,
            //'multipart' => $multiPart->toArray(),
          ]
          );

      } catch (ClientException $e) {
        //print $e->getMessage() . "\n";
        //print_r($e->getResponse()->getBody());
        print "Request:\n";
        print_r($e->getRequest()->getHeaders());
        print $e->getRequest()->getBody();
        print "\n---\nResponse:\n";
        print_r($e->getResponse()->getHeaders());
        print $e->getResponse()->getBody();
        print "\n";
        throw new \RuntimeException("Something went wrong", 0, $e);
      }
      return $this->parent->parseResponse($response, $responseType);
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
    } catch (\Exception $e) {
      throw new RuntimeIOException($e->getMessage(), 0, $e);
    }
  }
}