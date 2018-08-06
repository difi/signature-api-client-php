<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\ConfirmationReference;

/**
 * An entity received from the Signature API which must be confirmed
 * as received by the client. The confirmation may result in resource(s)
 * being made unavailable to the client. Typically, if the confirmation is
 * for received status of a complete (signed or cancelled) job, the server
 * is free to handle the job as it see fit, e.g make the job unavailable to
 * the client through the API.
 * <p>
 *   <strong>Confirming is a required part of the communication protocol with
 *   the Signature API.</strong>
 * <p>
 * Please refer to the documentation of each confirmation case for any specific
 * consequences of confirming a received entity.
 */
interface Confirmable {

  function getConfirmationReference(): ConfirmationReference;
}

