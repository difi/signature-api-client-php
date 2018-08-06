<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 10.07.18
 * Time: 08:55
 */

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\API\XML\XMLDirectSignatureJobResponse;
use Digipost\Signature\API\XML\XMLDirectSignatureJobStatus;
use Digipost\Signature\API\XML\XMLDirectSignatureJobStatusResponse;
use Digipost\Signature\API\XML\XMLSignerSpecificUrl;
use Digipost\Signature\Client\Core\ConfirmationReference;
use Digipost\Signature\Client\Core\DeleteDocumentsUrl;
use Digipost\Signature\Client\Core\Internal\JobStatusResponse;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Digipost\Signature\Client\Core\PAdESReference;
use Digipost\Signature\Client\Core\XAdESReference;
use Digipost\Signature\Client\Direct\JaxbEntityMapping;
use Digipost\Signature\Client\Direct\DirectJobResponse;
use Tests\DigipostSignatureBundle\Client\ClientBaseTestCase;

class DirectJobStatusTest extends ClientBaseTestCase {

  public function testSomeOption() {
    $signatures = [];
    $signatures[0] = new Signature(
      '27068648748',
      new SignerStatus("SIGNED"),
      new \DateTime(), XAdESReference::of('http://localhost/xadesref')
    );
    $signatures[1] = new Signature(
      '11238648723',
      new SignerStatus("SIGNED"),
      new \DateTime(), XAdESReference::of('http://localhost/xadesref')
    );
    $signatures[2] = new Signature(
      '12345678910',
      new SignerStatus("SIGNED"),
      new \DateTime(), XAdESReference::of('http://localhost/xadesref')
    );

    $obj = new DirectJobStatusResponse(
      12345,
      DirectJobStatus::COMPLETED_SUCCESSFULLY(),
      ConfirmationReference::of('http://localhost'),
      DeleteDocumentsUrl::of('http://localhost/delete'),
      $signatures,
      PAdESReference::of('http://localhost/pades'),
      new \DateTime());

    $test = $obj->getSignatureFrom('11238648723');
    $this->assertSame($signatures[1], $test);

    $this->expectException(\InvalidArgumentException::class);
    $obj->getSignatureFrom('11238648222');
  }

  /**
   * @throws \Exception
   */
  public function testAbleToUnserializeJobResponseXML() {
    $directResponseXml = self::$resourcesFolder . '/xml/direct-signature-job-response.xml';
    $xml = file_get_contents($directResponseXml);

    /** @var XMLDirectSignatureJobResponse $entityObj */
    $entityXmlObj = Marshalling::unmarshal($xml, XMLDirectSignatureJobResponse::class);
    $this->assertInstanceOf(XMLDirectSignatureJobResponse::class, $entityXmlObj);

    /** @var DirectJobResponse $entityObj */
    $entityObj = JaxbEntityMapping::fromJaxb($entityXmlObj);
    $this->assertInstanceOf(DirectJobResponse::class, $entityObj);

    $this->assertSame(12058, $entityObj->getSignatureJobId());
    $this->assertSame('https://difitest.signering.posten.no/signere/#/-/Ov9V04CpfJ5x2rDts5Vs71tPbsIcGDqvrCdvoO2q9A8',
      $entityObj->getSingleRedirectUrl());
    $this->assertSame('https://difitest.signering.posten.no/signere/#/-/Ov9V04CpfJ5x2rDts5Vs71tPbsIcGDqvrCdvoO2q9A8',
      $entityObj->getRedirectUrls()->getFor('28129307058'));
    $this->assertSame('bendiks job', $entityObj->getReference());
    $this->assertSame('https://api.difitest.signering.posten.no/api/991825827/direct/signature-jobs/12058/status',
      $entityObj->getStatusUrl());
  }

  public function testAbleToUnserializeJobStatusResponseXML() {
    $directResponseXml = self::$resourcesFolder . '/xml/direct-signature-job-status-response.xml';
    $xml = file_get_contents($directResponseXml);

    /** @var XMLDirectSignatureJobStatusResponse $xmlSignatureJobStatusResponse */
    $xmlSignatureJobStatusResponse = Marshalling::unmarshal($xml, XMLDirectSignatureJobStatusResponse::class);
    $this->assertInstanceOf(XMLDirectSignatureJobStatusResponse::class, $xmlSignatureJobStatusResponse);

    $signatureJobStatusResponse = JaxbEntityMapping::fromJaxb_XMLDirectSignatureJobStatusResponse($xmlSignatureJobStatusResponse, NULL);
    $this->assertInstanceOf(DirectJobStatusResponse::class, $signatureJobStatusResponse);
  }

  public function testAbleToConvertAllStatusesFromXsd() {

    $convertedStatuses = [];
    foreach (XMLDirectSignatureJobStatus::values() as $xmlStatus) {
      $convertedStatuses[] = DirectJobStatus::fromXmlType($xmlStatus);
    }
    $this->assertSameSize(XMLDirectSignatureJobStatus::values(), $convertedStatuses);
  }
}
