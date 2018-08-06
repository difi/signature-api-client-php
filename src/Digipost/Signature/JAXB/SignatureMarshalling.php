<?php

namespace Digipost\Signature\JAXB;

use Digipost\Signature\API\XML\Thirdparty\ASiCe\XAdESSignatures;
use Digipost\Signature\API\XML\Thirdparty\XAdES\QualifyingProperties;
use Digipost\Signature\API\XML\XMLDirectSignatureJobManifest;
use Digipost\Signature\API\XML\XMLDirectSignatureJobRequest;
use Digipost\Signature\API\XML\XMLDirectSignatureJobResponse;
use Digipost\Signature\API\XML\XMLDirectSignatureJobStatusResponse;
use Digipost\Signature\API\XML\XMLError;
use Digipost\Signature\API\XML\XMLPortalSignatureJobManifest;
use Digipost\Signature\API\XML\XMLPortalSignatureJobRequest;
use Digipost\Signature\API\XML\XMLPortalSignatureJobResponse;
use Digipost\Signature\API\XML\XMLPortalSignatureJobStatusChangeResponse;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Ds\Set;

/**
 * Different sets of classes to be bound by a
 * {@link \JMS\Serializer\Context JMS context} in order to create
 * {@link \JMS\Serializer\SerializerInterface::serialize() marshallers} and
 * {@link \JMS\Serializer\SerializerInterface::deserialize() unmarshallers}. All the sets are immutable.
 *
 * @see Marshalling::marshal()
 * @see Marshalling::unmarshal()
 */
final class SignatureMarshalling {

  /**
   * All classes necessary to handle marshalling and unmarshalling
   * *requests and responses* for both the {@link DirectClient Direct-} and {@link PortalClient Portal API}.
   */
  public static function allApiClasses(): Set {
    return self::unionOf(
      self::allApiRequestClasses(),
      self::allApiResponseClasses()
    );
  }

  /**
   * All classes necessary to handle marshalling
   * *requests* to both the {@link DirectClient Direct} and {@link PortalClient Portal API}.
   */
  public static function allApiRequestClasses(): Set {
    return self::unionOf(
      self::commonJaxbClassesForRequests(),
      self::directApiJaxbClassesForRequests(),
      self::portalApiJaxbClassesForRequests()
    );
  }

  /**
   * All classes necessary to handle unmarshalling
   * *responses* from both the {@link DirectClient Direct} and {@link PortalClient Portal API}.
   */
  public static function allApiResponseClasses(): Set {
    return self::unionOf(
      self::commonJaxbClassesForResponses(),
      self::directApiJaxbClassesForResponses(),
      self::portalApiJaxbClassesForResponses()
    );
  }


  /**
   * All classes necessary to handle marshalling
   * *requests* to the {@link DirectClient Direct API}.
   */
  public static function directApiJaxbClassesForRequests(): Set {
    return self::unionOf(
      self::commonJaxbClassesForRequests(),
      XMLDirectSignatureJobRequest::class,
      XMLDirectSignatureJobManifest::class
    );
  }

  /**
   * All classes necessary to handle unmarshalling
   * *responses* from the {@link DirectClient Direct API}.
   */
  public static function directApiJaxbClassesForResponses(): Set {
    return self::unionOf(
      self::commonJaxbClassesForResponses(),
      XMLDirectSignatureJobResponse::class,
      XMLDirectSignatureJobStatusResponse::class
    );
  }

  /**
   * All classes necessary to handle marshalling
   * *requests* to the {@link PortalClient Portal API}.
   */
  public static function portalApiJaxbClassesForRequests(): Set {
    return self::unionOf(
      self::commonJaxbClassesForRequests(),
      XMLPortalSignatureJobManifest::class,
      XMLPortalSignatureJobRequest::class
    );
  }

  /**
   * All classes necessary to handle unmarshalling
   * *responses* from the {@link PortalClient Portal API}.
   */
  public static function portalApiJaxbClassesForResponses(): Set {
    return self::unionOf(
      self::commonJaxbClassesForResponses(),
      XMLPortalSignatureJobResponse::class,
      XMLPortalSignatureJobStatusChangeResponse::class
    );
  }


  private static function commonJaxbClassesForResponses(): Set {
    return new Set([XMLError::class]);
  }

  private static function commonJaxbClassesForRequests(): Set {
    return self::unionOf(
      [], QualifyingProperties::class,
      XAdESSignatures::class
    );
  }

  private static function unionOf($set1, ...$more): Set {
    $union = $set1;
    if (!($union instanceof Set)) {
      $union = new Set($set1);
    }
    foreach ($more as $value) {
      if ($value instanceof Set) {
        $union = $union->union($value);
      }
      else {
        $union->add($value);
      }
    }
    return $union;
  }
}
