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
use Digipost\Signature\Client\Core\Exceptions\DocumentsNotDeletableException;
use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;
use Digipost\Signature\Client\Core\Exceptions\TooEagerPollingException;
use Digipost\Signature\Client\Core\Exceptions\UnexpectedResponseException;
use Digipost\Signature\Client\Core\Internal\Http\SignatureHttpClient;
use Digipost\Signature\Client\Core\Internal\Http\ResponseStatus;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Direct\DirectJobResponse;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Response;
use PhpOffice\PhpWord\Exception\Exception;
use Symfony\Component\Filesystem\Exception\IOException;

class ClientHelper {

  //private static final Logger LOG = LoggerFactory.getLogger(ClientHelper.class);

  const NEXT_PERMITTED_POLL_TIME_HEADER = "X-Next-permitted-poll-time";

  const POLLING_QUEUE_QUERY_PARAMETER = "polling_queue";

  private $httpClient;

  private $globalSender;

  private $clientExceptionMapper;

  public function __construct(SignatureHttpClient $httpClient,
                              Sender $globalSender) {
    $this->httpClient = $httpClient;
    $this->globalSender = $globalSender;
    $this->clientExceptionMapper = new ClientExceptionMapper();
  }

  public function sendSignatureJobRequest(XMLDirectSignatureJobRequest $signatureJobRequest,
                                          DocumentBundle $documentBundle,
                                          Sender $sender = NULL) {
    $actualSender = ActualSender::getActualSender($sender, $this->globalSender);

    $signatureJobBodyPart = new BodyPart($signatureJobRequest,
                                         'application/xml');
    $documentBundleBodyPart = new BodyPart($documentBundle->getInputStream(),
                                           'application/octet-stream');

    return $this->call(function () use (
      $signatureJobBodyPart, $documentBundleBodyPart, $actualSender
    ) {
      $usingBodyParts = new UsingBodyParts($this, $signatureJobBodyPart,
                                           $documentBundleBodyPart);
      return $usingBodyParts->postAsMultiPart(Target::DIRECT()
                                                ->path($actualSender),
                                              XMLDirectSignatureJobResponse::class);
    });
  }

  public function sendPortalSignatureJobRequest(XMLPortalSignatureJobRequest $signatureJobRequest,
                                                DocumentBundle $documentBundle,
                                                Sender $sender) {
    $actualSender = ActualSender::getActualSender($sender, $this->globalSender);

    $signatureJobBodyPart = new BodyPart($signatureJobRequest,
                                         'application/xml');
    $documentBundleBodyPart = new BodyPart($documentBundle->getInputStream(),
                                           'application/octet-stream');
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
    return $this->getStatusChange($sender, PORTAL,
                                  XMLPortalSignatureJobStatusChangeResponse::class);
  }

  public function getDirectStatusChange(Sender $sender) {
    return $this->getStatusChange($sender, DIRECT,
                                  XMLDirectSignatureJobStatusResponse::class);
  }

  private function getStatusChange(Sender $sender, Target $target,
                                   $responseClass) {
    return $this->call(function () use ($responseClass, $target, $sender) {
      $actualSender = $this->getActualSender($sender, $this->globalSender);
      $request = httpClient::signatureServiceRoot()
        ->path($target->path($actualSender))
        ->queryParam(self::POLLING_QUEUE_QUERY_PARAMETER,
                     $actualSender->getPollingQueue()->value)
        ->request()
        ->accept(APPLICATION_XML_TYPE);
      try {
        $response = $request->get();
        $status = ResponseStatus::resolve($response->getStatus());
        if ($status == NO_CONTENT) {
          return new JobStatusResponse(NULL,
                                       $this->getNextPermittedPollTime($response));
        }
        else {
          if ($status == OK) {
            return new JobStatusResponse($response->readEntity($responseClass),
                                         $this->getNextPermittedPollTime($response));
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
    });
  }

  private static function getNextPermittedPollTime(Response $response) {
    //return ZonedDateTime.parse(response.getHeaderString(NEXT_PERMITTED_POLL_TIME_HEADER), ISO_DATE_TIME).toInstant();
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
    $this->call(function () use ($deleteDocumentsUrl) {
      if ($deleteDocumentsUrl !== NULL) {
        $url = $deleteDocumentsUrl->getUrl();
        try {
          $response = $this->delete($url);
          $status = ResponseStatus::resolve($response->getStatus());
          if ($status == OK) {
            return;
          }
          throw $this->exceptionForGeneralError($response);
        } catch (\Exception $e) {
        }
      }
      else {
        throw new DocumentsNotDeletableException();
      }
    });
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
    $status = ResponseStatus::resolve($response->getStatus());
    if ($status === "OK") {
      return $response->readEntity($responseType);
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
    return new UnexpectedResponseException($error,
                                           ResponseStatus::resolve($response->getStatus()),
                                           OK);
  }

  private static function extractError(Response $response) {
    $error = NULL;
    $responseContentType = $response->getHeaderString(HttpHeaders . CONTENT_TYPE);
    //        if ($responseContentType->isPresent() && MediaType.valueOf(responseContentType.get()).equals(APPLICATION_XML_TYPE)) {
    //            try {
    //                response.bufferEntity();
    //                error = response.readEntity(XMLError.class);
    //            } catch (Exception e) {
    //                throw new UnexpectedResponseException(
    //                        HttpHeaders.CONTENT_TYPE + " " + responseContentType.orElse("unknown") + ": " +
    //                        Optional.ofNullable(response.readEntity(String.class)).filter(StringUtils::isNoneBlank).orElse("<no content in response>"),
    //                        e, ResponseStatus.resolve(response.getStatus()), OK);
    //            }
    //        } else {
    //            throw new UnexpectedResponseException(
    //                    HttpHeaders.CONTENT_TYPE + " " + responseContentType.orElse("unknown") + ": " +
    //                    Optional.ofNullable(response.readEntity(String.class)).filter(StringUtils::isNoneBlank).orElse("<no content in response>"),
    //                    ResponseStatus.resolve(response.getStatus()), OK);
    //        }
    //        if ($error === null) {
    //            throw new UnexpectedResponseException(null, ResponseStatus.resolve(response.getStatus()), OK);
    //        }
    return $error;
  }
}

class BodyPart {

  private $entity;

  private $mediaType;

  function __construct($entity, $mediaType) {
    if (isset($entity) && !is_string($entity)) {
      $contents = NULL;
      Marshalling::marshal($entity, $contents);
      $this->entity = $contents->saveXML();
    } else {
      $this->entity = $entity;
    }
    $this->mediaType = $mediaType;
  }

  function toArray() {
    return [
      'name' => 'ID_' . hash('sha1', $this->entity),
      'contents' => $this->entity,
//      'headers' => [
//        'Content-Type' => $this->mediaType,
//      ],
    ];
  }
}

class MultiPart extends BodyPart {

  private $bodyParts = [];

  function __construct($entity = NULL, $mediaType = NULL) {
    parent::__construct($entity, 'multipart/mixed');
  }

  function bodyPart($bodyPart) {
    $this->bodyParts[] = $bodyPart;
  }

  function toArray() {
    $ret = [];
    foreach ($this->bodyParts as $x => $bodyPart) {
      $key = "ID_$x";
      $ret[$key] = $bodyPart->toArray();
    }
    return $ret;
  }
}

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
        $response = $this->parent->getHttpClient()->signatureServiceRoot()
          ->post($path, [
            'headers' => [
              'Content-Type' => 'multipart/mixed',
              'Accept' => 'application/xml',
            ],
            'multipart' => $multiPart->toArray(),
          ]);
      } catch (ClientException $e) {
        print $e->getMessage() . "\n";
        //print_r($e->getResponse()->getBody());
        print $e->getRequest()->getBody();
      }

      return $this->parent->parseResponse($response, $responseType);
    } catch (IOException $e) {
      throw new RuntimeIOException(e);
    }
  }
}