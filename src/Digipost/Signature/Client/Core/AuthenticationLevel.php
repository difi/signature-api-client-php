<?php
namespace Digipost\Signature\Client\Core;

use Digipost\Signature\API\XML\XMLAuthenticationLevel;
use MyCLabs\Enum\Enum;

/**
 * Class AuthenticationLevel
 *
 * @package Digipost\Signature\Client\Core
 *
 * @method static AuthenticationLevel THREE
 * @method static AuthenticationLevel FOUR
 */
class AuthenticationLevel extends Enum {
	const THREE = XMLAuthenticationLevel::THREE;
	const FOUR = XMLAuthenticationLevel::FOUR;

  function getXmlEnumValue() {
    return new XMLAuthenticationLevel($this->value);
  }
}

