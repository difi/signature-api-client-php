<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing CertificateValuesType
 *
 *
 * XSD Type: CertificateValuesType
 */
class CertificateValuesType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $encapsulatedX509Certificate
     */
    private $encapsulatedX509Certificate = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $otherCertificate
     */
    private $otherCertificate = array(
        
    );

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
     * Adds as encapsulatedX509Certificate
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $encapsulatedX509Certificate
     */
    public function addToEncapsulatedX509Certificate(\Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $encapsulatedX509Certificate)
    {
        $this->encapsulatedX509Certificate[] = $encapsulatedX509Certificate;
        return $this;
    }

    /**
     * isset encapsulatedX509Certificate
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetEncapsulatedX509Certificate($index)
    {
        return isset($this->encapsulatedX509Certificate[$index]);
    }

    /**
     * unset encapsulatedX509Certificate
     *
     * @param scalar $index
     * @return void
     */
    public function unsetEncapsulatedX509Certificate($index)
    {
        unset($this->encapsulatedX509Certificate[$index]);
    }

    /**
     * Gets as encapsulatedX509Certificate
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[]
     */
    public function getEncapsulatedX509Certificate()
    {
        return $this->encapsulatedX509Certificate;
    }

    /**
     * Sets a new encapsulatedX509Certificate
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $encapsulatedX509Certificate
     * @return self
     */
    public function setEncapsulatedX509Certificate(array $encapsulatedX509Certificate)
    {
        $this->encapsulatedX509Certificate = $encapsulatedX509Certificate;
        return $this;
    }

    /**
     * Adds as otherCertificate
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $otherCertificate
     */
    public function addToOtherCertificate(\Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $otherCertificate)
    {
        $this->otherCertificate[] = $otherCertificate;
        return $this;
    }

    /**
     * isset otherCertificate
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetOtherCertificate($index)
    {
        return isset($this->otherCertificate[$index]);
    }

    /**
     * unset otherCertificate
     *
     * @param scalar $index
     * @return void
     */
    public function unsetOtherCertificate($index)
    {
        unset($this->otherCertificate[$index]);
    }

    /**
     * Gets as otherCertificate
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[]
     */
    public function getOtherCertificate()
    {
        return $this->otherCertificate;
    }

    /**
     * Sets a new otherCertificate
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $otherCertificate
     * @return self
     */
    public function setOtherCertificate(array $otherCertificate)
    {
        $this->otherCertificate = $otherCertificate;
        return $this;
    }


}

