<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use Digipost\Signature\Client\Core\Internal\Util;
use MyCLabs\Enum\Enum;

interface StatusType {

  /**
   * Get the associated status code.
   *
   * @return int
   */
  public function getStatusCode(): int;

  /**
   * Get the class of status code.
   *
   * @return StatusFamily
   */
  public function getFamily(): StatusFamily;

  /**
   * Get the reason phrase.
   *
   * @return String
   */
  public function getReasonPhrase(): String;
}

/**
 * @method static Status OK()                               200 OK                               see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.1">HTTP/1.1 documentation</a>
 * @method static Status CREATED()                          201 Created                          see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.2">HTTP/1.1 documentation</a>
 * @method static Status ACCEPTED()                         202 Accepted                         see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.3">HTTP/1.1 documentation</a>
 * @method static Status NO_CONTENT()                       204 No Content                       see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.5">HTTP/1.1 documentation</a>
 * @method static Status RESET_CONTENT()                    205 Reset Content                    see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.6">HTTP/1.1 documentation</a>
 * @method static Status PARTIAL_CONTENT()                  206 Reset Content                    see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.7">HTTP/1.1 documentation</a>
 * @method static Status MOVED_PERMANENTLY()                301 Moved Permanently                see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.2">HTTP/1.1 documentation</a>
 * @method static Status FOUND()                            302 Found                            see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.3">HTTP/1.1 documentation</a>
 * @method static Status SEE_OTHER()                        303 See Other                        see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.4">HTTP/1.1 documentation</a>
 * @method static Status NOT_MODIFIED()                     304 Not Modified                     see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.5">HTTP/1.1 documentation</a>
 * @method static Status USE_PROXY()                        305 Use Proxy                        see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.6">HTTP/1.1 documentation</a>
 * @method static Status TEMPORARY_REDIRECT()               307 Temporary Redirect               see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.8">HTTP/1.1 documentation</a>
 * @method static Status BAD_REQUEST()                      400 Bad Request                      see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.1">HTTP/1.1 documentation</a>
 * @method static Status UNAUTHORIZED()                     401 Unauthorized                     see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.2">HTTP/1.1 documentation</a>
 * @method static Status PAYMENT_REQUIRED()                 402 Payment Required                 see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.3">HTTP/1.1 documentation</a>
 * @method static Status FORBIDDEN()                        403 Forbidden                        see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.4">HTTP/1.1 documentation</a>
 * @method static Status NOT_FOUND()                        404 Not Found                        see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.5">HTTP/1.1 documentation</a>
 * @method static Status METHOD_NOT_ALLOWED()               405 Method Not Allowed               see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.6">HTTP/1.1 documentation</a>
 * @method static Status NOT_ACCEPTABLE()                   406 Not Acceptable                   see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.7">HTTP/1.1 documentation</a>
 * @method static Status PROXY_AUTHENTICATION_REQUIRED()    407 Proxy Authentication Required    see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.8">HTTP/1.1 documentation</a>
 * @method static Status REQUEST_TIMEOUT()                  408 Request Timeout                  see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.9">HTTP/1.1 documentation</a>
 * @method static Status CONFLICT()                         409 Conflict                         see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.10">HTTP/1.1 documentation</a>
 * @method static Status GONE()                             410 Gone                             see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.11">HTTP/1.1 documentation</a>
 * @method static Status LENGTH_REQUIRED()                  411 Length Required                  see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.12">HTTP/1.1 documentation</a>
 * @method static Status PRECONDITION_FAILED()              412 Precondition Failed              see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.13">HTTP/1.1 documentation</a>
 * @method static Status REQUEST_ENTITY_TOO_LARGE()         413 Request Entity Too Large         see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.14">HTTP/1.1 documentation</a>
 * @method static Status REQUEST_URI_TOO_LONG()             414 Request-URI Too Long             see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.15">HTTP/1.1 documentation</a>
 * @method static Status UNSUPPORTED_MEDIA_TYPE()           415 Unsupported Media Type           see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.16">HTTP/1.1 documentation</a>
 * @method static Status REQUESTED_RANGE_NOT_SATISFIABLE()  416 Requested Range Not Satisfiable  see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.17">HTTP/1.1 documentation</a>
 * @method static Status EXPECTATION_FAILED()               417 Expectation Failed               see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.18">HTTP/1.1 documentation</a>
 * @method static Status INTERNAL_SERVER_ERROR()            500 Internal Server Error            see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.1">HTTP/1.1 documentation</a>
 * @method static Status NOT_IMPLEMENTED()                  501 Not Implemented                  see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.2">HTTP/1.1 documentation</a>
 * @method static Status BAD_GATEWAY()                      502 Bad Gateway                      see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.3">HTTP/1.1 documentation</a>
 * @method static Status SERVICE_UNAVAILABLE()              503 Service Unavailable              see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.4">HTTP/1.1 documentation</a>
 * @method static Status GATEWAY_TIMEOUT()                  504 Gateway Timeout                  see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.5">HTTP/1.1 documentation</a>
 * @method static Status HTTP_VERSION_NOT_SUPPORTED()       505 HTTP Version Not Supported       see <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.6">HTTP/1.1 documentation</a>
 */
class Status extends Enum implements StatusType {

  /**
   * 200 OK, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.1">HTTP/1.1 documentation</a>}.
   */
  const OK = [200, "OK"];

  /**
   * 201 Created, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.2">HTTP/1.1 documentation</a>}.
   */
  const CREATED = [201, "Created"];

  /**
   * 202 Accepted, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.3">HTTP/1.1 documentation</a>}.
   */
  const ACCEPTED = [202, "Accepted"];

  /**
   * 204 No Content, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.5">HTTP/1.1 documentation</a>}.
   */
  const NO_CONTENT = [204, "No Content"];

  /**
   * 205 Reset Content, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.6">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const RESET_CONTENT = [205, "Reset Content"];

  /**
   * 206 Reset Content, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.2.7">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const PARTIAL_CONTENT = [206, "Partial Content"];

  /**
   * 301 Moved Permanently, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.2">HTTP/1.1 documentation</a>}.
   */
  const MOVED_PERMANENTLY = [301, "Moved Permanently"];

  /**
   * 302 Found, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.3">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const FOUND = [302, "Found"];

  /**
   * 303 See Other, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.4">HTTP/1.1 documentation</a>}.
   */
  const SEE_OTHER = [303, "See Other"];

  /**
   * 304 Not Modified, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.5">HTTP/1.1 documentation</a>}.
   */
  const NOT_MODIFIED = [304, "Not Modified"];

  /**
   * 305 Use Proxy, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.6">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const USE_PROXY = [305, "Use Proxy"];

  /**
   * 307 Temporary Redirect, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.8">HTTP/1.1 documentation</a>}.
   */
  const TEMPORARY_REDIRECT = [307, "Temporary Redirect"];

  /**
   * 400 Bad Request, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.1">HTTP/1.1 documentation</a>}.
   */
  const BAD_REQUEST = [400, "Bad Request"];

  /**
   * 401 Unauthorized, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.2">HTTP/1.1 documentation</a>}.
   */
  const UNAUTHORIZED = [401, "Unauthorized"];

  /**
   * 402 Payment Required, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.3">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const PAYMENT_REQUIRED = [402, "Payment Required"];

  /**
   * 403 Forbidden, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.4">HTTP/1.1 documentation</a>}.
   */
  const FORBIDDEN = [403, "Forbidden"];

  /**
   * 404 Not Found, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.5">HTTP/1.1 documentation</a>}.
   */
  const NOT_FOUND = [404, "Not Found"];

  /**
   * 405 Method Not Allowed, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.6">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const METHOD_NOT_ALLOWED = [405, "Method Not Allowed"];

  /**
   * 406 Not Acceptable, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.7">HTTP/1.1 documentation</a>}.
   */
  const NOT_ACCEPTABLE = [406, "Not Acceptable"];

  /**
   * 407 Proxy Authentication Required, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.8">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const PROXY_AUTHENTICATION_REQUIRED = [407, "Proxy Authentication Required"];

  /**
   * 408 Request Timeout, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.9">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const REQUEST_TIMEOUT = [408, "Request Timeout"];

  /**
   * 409 Conflict, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.10">HTTP/1.1 documentation</a>}.
   */
  const CONFLICT = [409, "Conflict"];

  /**
   * 410 Gone, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.11">HTTP/1.1 documentation</a>}.
   */
  const GONE = [410, "Gone"];

  /**
   * 411 Length Required, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.12">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const LENGTH_REQUIRED = [411, "Length Required"];

  /**
   * 412 Precondition Failed, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.13">HTTP/1.1 documentation</a>}.
   */
  const PRECONDITION_FAILED = [412, "Precondition Failed"];

  /**
   * 413 Request Entity Too Large, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.14">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const REQUEST_ENTITY_TOO_LARGE = [413, "Request Entity Too Large"];

  /**
   * 414 Request-URI Too Long, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.15">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const REQUEST_URI_TOO_LONG = [414, "Request-URI Too Long"];

  /**
   * 415 Unsupported Media Type, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.16">HTTP/1.1 documentation</a>}.
   */
  const UNSUPPORTED_MEDIA_TYPE = [415, "Unsupported Media Type"];

  /**
   * 416 Requested Range Not Satisfiable, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.17">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const REQUESTED_RANGE_NOT_SATISFIABLE = [
    416,
    "Requested Range Not Satisfiable",
  ];

  /**
   * 417 Expectation Failed, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.18">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const EXPECTATION_FAILED = [417, "Expectation Failed"];

  /**
   * 500 Internal Server Error, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.1">HTTP/1.1 documentation</a>}.
   */
  const INTERNAL_SERVER_ERROR = [500, "Internal Server Error"];

  /**
   * 501 Not Implemented, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.2">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const NOT_IMPLEMENTED = [501, "Not Implemented"];

  /**
   * 502 Bad Gateway, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.3">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const BAD_GATEWAY = [502, "Bad Gateway"];

  /**
   * 503 Service Unavailable, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.4">HTTP/1.1 documentation</a>}.
   */
  const SERVICE_UNAVAILABLE = [503, "Service Unavailable"];

  /**
   * 504 Gateway Timeout, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.5">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const GATEWAY_TIMEOUT = [504, "Gateway Timeout"];

  /**
   * 505 HTTP Version Not Supported, see {@link <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.5.6">HTTP/1.1 documentation</a>}.
   *
   * @since 2.0
   */
  const HTTP_VERSION_NOT_SUPPORTED = [505, "HTTP Version Not Supported"];

  /** @var int */
  private $code;

  /** @var String */
  private $reason;

  /** @var StatusFamily */
  private $family;

  public function __construct(array $value) {
    parent::__construct($value);
    $this->code = $value[0];
    $this->reason = $value[1];
    $this->family = StatusFamily::familyOf($this->code);
  }

  public function getStatusCode(): int {
    return $this->code;
  }

  public function getFamily(): StatusFamily {
    return $this->family;
  }

  public function getReasonPhrase(): String {
    return $this->reason;
  }

  public function __toString() {
    return $this->reason;
  }

  /**
   * Convert a numerical status code into the corresponding Status.
   *
   * @param int $statusCode
   *
   * @return Status|NULL
   */
  public static function fromStatusCode(int $statusCode) {
    /** @var Status $s */
    foreach (Status::values() as $s) {
      if ($s->getStatusCode() === $statusCode) {
        return $s;
      }
    }
    return NULL;
  }
}

/**
 * @method static UNPROCESSABLE_ENTITY()     422 Unprocessable Entity  see <a href="https://tools.ietf.org/html/rfc4918#section-11.2">RFC4918</a>.
 * @method static TOO_MANY_REQUESTS()        429 Too Many Requests     see <a href="https://tools.ietf.org/html/rfc6585#page-3">RFC6585</a>.
 */
class Custom extends Enum implements StatusType {

  /**
   * 422 Unprocessable Entity, see {@link https://tools.ietf.org/html/rfc4918#section-11.2 RFC4918}
   */
  const UNPROCESSABLE_ENTITY = [422, "Unprocessable Entity"];

  /**
   * 429 Too Many Requests, see {@link https://tools.ietf.org/html/rfc6585#page-3 RFC6585}
   */
  const TOO_MANY_REQUESTS = [429, "Too Many Requests"];

  /** @var int */
  private $code;

  /** @var String */
  private $reason;

  /** @var StatusFamily */
  private $family;

  public function __construct(array $value) {
    parent::__construct($value);
    $this->code = $value[0];
    $this->reason = $value[1];
    $this->family = StatusFamily::familyOf($this->code);
  }

  public function getStatusCode(): int {
    return $this->code;
  }

  public function getFamily(): StatusFamily {
    return $this->family;
  }

  public function getReasonPhrase(): String {
    return $this->reason;
  }

  public function __toString() {
    return $this->code . ' ' . $this->reason;
  }

  /**
   * Convert a numerical status code into the corresponding Status.
   *
   * @param int $statusCode
   *
   * @return Custom|NULL
   */
  public static function fromStatusCode(int $statusCode) {
    /** @var Custom $s */
    foreach (Custom::values() as $s) {
      if ($s->getStatusCode() === $statusCode) {
        return $s;
      }
    }
    return NULL;
  }
}

/**
 * An enumeration representing the class of status code.
 *
 * @method static INFORMATIONAL()  1xx HTTP status codes.
 * @method static SUCCESSFUL()     2xx HTTP status codes.
 * @method static REDIRECTION()    3xx HTTP status codes.
 * @method static CLIENT_ERROR()   4xx HTTP status codes.
 * @method static SERVER_ERROR()   5xx HTTP status codes.
 * @method static OTHER()          Other, unrecognized HTTP status codes.
 */
class StatusFamily extends Enum {

  /**
   * `1xx` HTTP status codes.
   */
  const INFORMATIONAL = 'INFORMATIONAL';

  /**
   * `2xx` HTTP status codes.
   */
  const SUCCESSFUL = 'SUCCESSFUL';

  /**
   * `3xx` HTTP status codes.
   */
  const REDIRECTION = 'REDIRECTION';

  /**
   * `4xx` HTTP status codes.
   */
  const CLIENT_ERROR = 'CLIENT_ERROR';

  /**
   * `5xx` HTTP status codes.
   */
  const SERVER_ERROR = 'SERVER_ERROR';

  /**
   * Other, unrecognized HTTP status codes.
   */
  const OTHER = 'OTHER';

  /**
   * Get the response status family for the status code.
   *
   * @param int $statusCode
   *
   * @return StatusFamily of the response status code.
   */
  public static function familyOf(int $statusCode): StatusFamily {
    switch ($statusCode / 100) {
      case 1:
        return StatusFamily::INFORMATIONAL();
      case 2:
        return StatusFamily::SUCCESSFUL();
      case 3:
        return StatusFamily::REDIRECTION();
      case 4:
        return StatusFamily::CLIENT_ERROR();
      case 5:
        return StatusFamily::SERVER_ERROR();
      default:
        return StatusFamily::OTHER();
    }
  }
}

class Unknown implements StatusType {

  /** @var int */
  private $code;

  /** @var String */
  private $reason;

  /** @var StatusFamily */
  private $family;

  public function __construct(int $code) {
    $this->code = $code;
    $this->family = StatusFamily::familyOf($code);
    $this->reason = "(" . $this->family . ", unrecognized status code)";
  }

  public function getStatusCode(): int {
    return $this->code;
  }

  public function getFamily(): StatusFamily {
    return $this->family;
  }

  public function getReasonPhrase(): String {
    return $this->reason;
  }

  public function equals($obj) {
    if ($obj instanceof Unknown) {
      $that = clone $obj;
      return $this->code === $that->getStatusCode();
    }
    return FALSE;
  }

  public function __toString() {
    return $this->code . ' ' . $this->reason;
  }

  public function hashCode() {
    return Util::hashCode($this->code);
  }
}

class ResponseStatus {

  /**
   * @param StatusType $status1
   * @param StatusType $status2
   *
   * @return bool
   */
  public static function equals(StatusType $status1, StatusType $status2) {
    return $status1->getFamily()->equals($status2->getFamily())
      && $status1->getStatusCode() === $status2->getStatusCode();
  }

  /**
   * @param int $code
   *
   * @return StatusType
   */
  public static function resolve(int $code): StatusType {
    $status = Status::fromStatusCode($code);
    if ($status === NULL) {
      $status = Custom::fromStatusCode($code);
    }
    if ($status === NULL) {
      $status = ResponseStatus::unknown($code);
    }
    return $status;
  }

  public static function unknown($code): Unknown {
    return new Unknown($code);
  }
}
