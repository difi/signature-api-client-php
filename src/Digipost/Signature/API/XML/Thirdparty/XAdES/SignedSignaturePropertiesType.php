<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing SignedSignaturePropertiesType
 *
 *
 * XSD Type: SignedSignaturePropertiesType
 */
class SignedSignaturePropertiesType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \DateTime $signingTime
     */
    private $signingTime = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType[] $signingCertificate
     */
    private $signingCertificate = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\SignaturePolicyIdentifierType $signaturePolicyIdentifier
     */
    private $signaturePolicyIdentifier = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\SignatureProductionPlaceType $signatureProductionPlace
     */
    private $signatureProductionPlace = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\SignerRoleType $signerRole
     */
    private $signerRole = null;

    /**
     * Gets as id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets a new id
     *
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Gets as signingTime
     *
     * @return \DateTime
     */
    public function getSigningTime()
    {
        return $this->signingTime;
    }

    /**
     * Sets a new signingTime
     *
     * @param \DateTime $signingTime
     * @return self
     */
    public function setSigningTime(\DateTime $signingTime)
    {
        $this->signingTime = $signingTime;
        return $this;
    }

    /**
     * Adds as cert
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType $cert
     */
    public function addToSigningCertificate(\Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType $cert)
    {
        $this->signingCertificate[] = $cert;
        return $this;
    }

    /**
     * isset signingCertificate
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSigningCertificate($index)
    {
        return isset($this->signingCertificate[$index]);
    }

    /**
     * unset signingCertificate
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSigningCertificate($index)
    {
        unset($this->signingCertificate[$index]);
    }

    /**
     * Gets as signingCertificate
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType[]
     */
    public function getSigningCertificate()
    {
        return $this->signingCertificate;
    }

    /**
     * Sets a new signingCertificate
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType[] $signingCertificate
     * @return self
     */
    public function setSigningCertificate(array $signingCertificate)
    {
        $this->signingCertificate = $signingCertificate;
        return $this;
    }

    /**
     * Gets as signaturePolicyIdentifier
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\SignaturePolicyIdentifierType
     */
    public function getSignaturePolicyIdentifier()
    {
        return $this->signaturePolicyIdentifier;
    }

    /**
     * Sets a new signaturePolicyIdentifier
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\SignaturePolicyIdentifierType $signaturePolicyIdentifier
     * @return self
     */
    public function setSignaturePolicyIdentifier(\Digipost\Signature\API\XML\Thirdparty\XAdES\SignaturePolicyIdentifierType $signaturePolicyIdentifier)
    {
        $this->signaturePolicyIdentifier = $signaturePolicyIdentifier;
        return $this;
    }

    /**
     * Gets as signatureProductionPlace
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\SignatureProductionPlaceType
     */
    public function getSignatureProductionPlace()
    {
        return $this->signatureProductionPlace;
    }

    /**
     * Sets a new signatureProductionPlace
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\SignatureProductionPlaceType $signatureProductionPlace
     * @return self
     */
    public function setSignatureProductionPlace(\Digipost\Signature\API\XML\Thirdparty\XAdES\SignatureProductionPlaceType $signatureProductionPlace)
    {
        $this->signatureProductionPlace = $signatureProductionPlace;
        return $this;
    }

    /**
     * Gets as signerRole
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\SignerRoleType
     */
    public function getSignerRole()
    {
        return $this->signerRole;
    }

    /**
     * Sets a new signerRole
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\SignerRoleType $signerRole
     * @return self
     */
    public function setSignerRole(\Digipost\Signature\API\XML\Thirdparty\XAdES\SignerRoleType $signerRole)
    {
        $this->signerRole = $signerRole;
        return $this;
    }


}

