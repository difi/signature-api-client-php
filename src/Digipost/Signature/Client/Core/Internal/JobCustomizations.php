<?php
namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\AuthenticationLevel;
use Digipost\Signature\Client\Core\IdentifierInSignedDocuments;
use Digipost\Signature\Client\Core\Sender;

interface JobCustomizations {

  /**
   * Set the sender for this specific signature job.
   * <p>
   * You may use {@link \Digipost\Signature\Client\ClientConfigurationBuilder::globalSender(Sender) globalSender(Sender)}
   * to specify a global sender used for all signature jobs.
   *
   * @param Sender $sender
   *
   * @return JobCustomizations
   */
  function withSender(Sender $sender);

  /**
   * Specify the minimum level of authentication of the signer(s) of this job. This
   * includes the required authentication both in order to <em>view</em> the document, as well
   * as it will limit which <em>authentication mechanisms offered at the time of signing</em>
   * the document.
   *
   * @param AuthenticationLevel $minimumLevel The required minimum AuthenticationLevel.
   *
   * @return JobCustomizations
   */
  function requireAuthentication(AuthenticationLevel $minimumLevel);

  /**
   * Set a custom reference that is attached to the job.
   *
   * @param String $reference The reference
   *
   * @return JobCustomizations
   */
  function withReference(String $reference);

  /**
   *  Specify how the signer(s) of this job should be identified in the signed documents (XAdES and PAdES);
   *  by {@link \Digipost\Signature\Client\Core\IdentifierInSignedDocuments::PERSONAL_IDENTIFICATION_NUMBER_AND_NAME personal identification number and name},
   *  {@link \Digipost\Signature\Client\Core\IdentifierInSignedDocuments::DATE_OF_BIRTH_AND_NAME date of birth and name} or
   *  {@link \Digipost\Signature\Client\Core\IdentifierInSignedDocuments::NAME name only}.
   *  <p>
   *  Not all options are available to every sender, this is detailed in the service's
   *  <a href="https://digipost.github.io/signature-api-specification">functional documentation</a>.
   *
   * @param IdentifierInSignedDocuments $identifier The identifier type
   */
  function withIdentifierInSignedDocuments(IdentifierInSignedDocuments $identifier);
}

