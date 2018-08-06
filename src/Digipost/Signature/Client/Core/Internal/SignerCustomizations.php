<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\OnBehalfOf;
use Digipost\Signature\Client\Core\SignatureType;

/**
 * Provides operations for customizing signers using builder-type methods for
 * properties which are common for both Direct and Portal signers.
 * You would not under normal circumstances refer to this type.
 */
interface SignerCustomizations {

  /**
   * Specify the {@link SignatureType type of signature} to use for the signer.
   *
   * @param SignatureType $type the {@link SignatureType}
   */
  function withSignatureType(SignatureType $type);

  /**
   * Specify which party the signer is {@link \Digipost\Signature\Client\Core\OnBehalfOf signing on behalf of}.
   *
   * @param OnBehalfOf $onBehalfOf the {@link \Digipost\Signature\Client\Core\OnBehalfOf OnBehalfOf}-value
   */
  function onBehalfOf(OnBehalfOf $onBehalfOf);
}

