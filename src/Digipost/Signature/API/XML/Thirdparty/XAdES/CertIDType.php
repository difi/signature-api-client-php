<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing CertIDType
 *
 *
 * XSD Type: CertIDType
 */
class CertIDType
{

    /**
     * @property string $uRI
     */
    private $uRI = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $certDigest
     */
    private $certDigest = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509IssuerSerialType $issuerSerial
     */
    private $issuerSerial = null;

    /**
     * Gets as uRI
     *
     * @return string
     */
    public function getURI()
    {
        return $this->uRI;
    }

    /**
     * Sets a new uRI
     *
     * @param string $uRI
     * @return self
     */
    public function setURI($uRI)
    {
        $this->uRI = $uRI;
        return $this;
    }

    /**
     * Gets as certDigest
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType
     */
    public function getCertDigest()
    {
        return $this->certDigest;
    }

    /**
     * Sets a new certDigest
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $certDigest
     * @return self
     */
    public function setCertDigest(\Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $certDigest)
    {
        $this->certDigest = $certDigest;
        return $this;
    }

    /**
     * Gets as issuerSerial
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509IssuerSerialType
     */
    public function getIssuerSerial()
    {
        return $this->issuerSerial;
    }

    /**
     * Sets a new issuerSerial
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509IssuerSerialType $issuerSerial
     * @return self
     */
    public function setIssuerSerial(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509IssuerSerialType $issuerSerial)
    {
        $this->issuerSerial = $issuerSerial;
        return $this;
    }


}

