<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 10.07.18
 * Time: 08:55
 */

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\API\XML\XMLDirectSignatureJobStatus;
use PHPUnit\Framework\TestCase;

class DirectJobStatusTest extends TestCase {

  public function testAbleToConvertAllStatusesFromXsd() {
    $convertedStatuses = [];
    foreach (XMLDirectSignatureJobStatus::values() as $xmlStatus) {
      $convertedStatuses[] = DirectJobStatus::fromXmlType($xmlStatus);
    }
    $this->assertSameSize(XMLDirectSignatureJobStatus::values(), $convertedStatuses);
  }
}
