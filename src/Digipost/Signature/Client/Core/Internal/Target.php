<?php
namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\Sender;
use MyCLabs\Enum\Enum;

/**
 * Class Target
 *
 * @package Digipost\Signature\Client\Core\Internal
 *
 * @method static Target PORTAL
 * @method static Target DIRECT
 */
class Target extends Enum {
	const PORTAL = "/%s/portal/signature-jobs";
	const DIRECT = "/%s/direct/signature-jobs";

	protected $path;

  function Target($value) {
    $this->path = $value;
  }

  function path(Sender $sender) {
    return sprintf($this->value, $sender->getOrganizationNumber());
  }
}
