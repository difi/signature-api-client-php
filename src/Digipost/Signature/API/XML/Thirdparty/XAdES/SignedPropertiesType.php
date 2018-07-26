<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing SignedPropertiesType
 *
 *
 * XSD Type: SignedPropertiesType
 */
class SignedPropertiesType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\SignedSignaturePropertiesType $signedSignatureProperties
     */
    private $signedSignatureProperties = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\SignedDataObjectPropertiesType $signedDataObjectProperties
     */
    private $signedDataObjectProperties = null;

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
     * Gets as signedSignatureProperties
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\SignedSignaturePropertiesType
     */
    public function getSignedSignatureProperties()
    {
        return $this->signedSignatureProperties;
    }

    /**
     * Sets a new signedSignatureProperties
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\SignedSignaturePropertiesType $signedSignatureProperties
     * @return self
     */
    public function setSignedSignatureProperties(\Digipost\Signature\API\XML\Thirdparty\XAdES\SignedSignaturePropertiesType $signedSignatureProperties)
    {
        $this->signedSignatureProperties = $signedSignatureProperties;
        return $this;
    }

    /**
     * Gets as signedDataObjectProperties
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\SignedDataObjectPropertiesType
     */
    public function getSignedDataObjectProperties()
    {
        return $this->signedDataObjectProperties;
    }

    /**
     * Sets a new signedDataObjectProperties
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\SignedDataObjectPropertiesType $signedDataObjectProperties
     * @return self
     */
    public function setSignedDataObjectProperties(\Digipost\Signature\API\XML\Thirdparty\XAdES\SignedDataObjectPropertiesType $signedDataObjectProperties)
    {
        $this->signedDataObjectProperties = $signedDataObjectProperties;
        return $this;
    }


}

