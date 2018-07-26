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
use Ds\Set;

/**
 * Different sets of classes to be bound by a
 * {@link javax.xml.bind.JAXBContext JAXB context} in order to create
 * marshallers and unmarshallers. All the sets are immutable.
 * <p>
 * If you use Spring, there are ready preconfigured
 * {@link org.springframework.oxm.jaxb.Jaxb2Marshaller}s available in
 * {@link SignatureJaxb2Marshaller}.
 */
final class SignatureMarshalling {

  /**
   * All classes necessary for a {@code JAXBContext} to handle marshalling and
   * unmarshalling
   * <em>requests and reponses</em> for both the Direct- and Portal API.
   */
  public static function allApiClasses(): Set {
    return self::unionOf(
      self::allApiRequestClasses(),
      self::allApiResponseClasses()
    );
  }

  /**
   * All classes necessary for a {@code JAXBContext} to handle marshalling
   * <em>requests</em> to both the Direct and Portal API.
   */
  public static function allApiRequestClasses(): Set {
    return self::unionOf(
      self::commonJaxbClassesForRequests(),
      self::directApiJaxbClassesForRequests(),
      self::portalApiJaxbClassesForRequests()
    );
  }

  /**
   * All classes necessary for a {@code JAXBContext} to handle unmarshalling
   * <em>responses</em> from both the Direct and Portal API.
   */
  public static function allApiResponseClasses(): Set {
    return self::unionOf(
      self::commonJaxbClassesForResponses(),
      self::directApiJaxbClassesForResponses(),
      self::portalApiJaxbClassesForResponses()
    );
  }


  /**
   * All classes necessary for a {@code JAXBContext} to handle marshalling
   * <em>requests</em> to the Direct API.
   */
  public static function directApiJaxbClassesForRequests(): Set {
    return self::unionOf(
      self::commonJaxbClassesForRequests(),
      XMLDirectSignatureJobRequest::class,
      XMLDirectSignatureJobManifest::class
    );
  }

  /**
   * All classes necessary for a {@code JAXBContext} to handle unmarshalling
   * <em>responses</em> from the Direct API.
   */
  public static function directApiJaxbClassesForResponses(): Set {
    return self::unionOf(
      self::commonJaxbClassesForResponses(),
      XMLDirectSignatureJobResponse::class,
      XMLDirectSignatureJobStatusResponse::class
    );
  }

  /**
   * All classes necessary for a {@code JAXBContext} to handle marshalling
   * <em>requests</em> to the Portal API.
   */
  public static function portalApiJaxbClassesForRequests(): Set {
    return self::unionOf(
      self::commonJaxbClassesForRequests(),
      XMLPortalSignatureJobManifest::class,
      XMLPortalSignatureJobRequest::class
    );
  }

  /**
   * All classes necessary for a {@code JAXBContext} to handle unmarshalling
   * <em>responses</em> from the Portal API.
   */
  public static function portalApiJaxbClassesForResponses(): Set {
    return self::unionOf(
      self::commonJaxbClassesForResponses(),
      XMLPortalSignatureJobResponse::class,
      XMLPortalSignatureJobStatusChangeResponse::class
    );
  }


  private static function commonJaxbClassesForResponses(): Set {
    /*return Collections.<Class<?>>singleton(XMLError.class);*/
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
