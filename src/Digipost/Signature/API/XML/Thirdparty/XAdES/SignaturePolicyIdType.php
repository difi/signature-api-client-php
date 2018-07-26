<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing SignaturePolicyIdType
 *
 *
 * XSD Type: SignaturePolicyIdType
 */
class SignaturePolicyIdType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifierType $sigPolicyId
     */
    private $sigPolicyId = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform[] $transforms
     */
    private $transforms = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $sigPolicyHash
     */
    private $sigPolicyHash = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $sigPolicyQualifiers
     */
    private $sigPolicyQualifiers = null;

    /**
     * Gets as sigPolicyId
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifierType
     */
    public function getSigPolicyId()
    {
        return $this->sigPolicyId;
    }

    /**
     * Sets a new sigPolicyId
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifierType $sigPolicyId
     * @return self
     */
    public function setSigPolicyId(\Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifierType $sigPolicyId)
    {
        $this->sigPolicyId = $sigPolicyId;
        return $this;
    }

    /**
     * Adds as transform
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform $transform
     */
    public function addToTransforms(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform $transform)
    {
        $this->transforms[] = $transform;
        return $this;
    }

    /**
     * isset transforms
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetTransforms($index)
    {
        return isset($this->transforms[$index]);
    }

    /**
     * unset transforms
     *
     * @param scalar $index
     * @return void
     */
    public function unsetTransforms($index)
    {
        unset($this->transforms[$index]);
    }

    /**
     * Gets as transforms
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform[]
     */
    public function getTransforms()
    {
        return $this->transforms;
    }

    /**
     * Sets a new transforms
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform[] $transforms
     * @return self
     */
    public function setTransforms(array $transforms)
    {
        $this->transforms = $transforms;
        return $this;
    }

    /**
     * Gets as sigPolicyHash
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType
     */
    public function getSigPolicyHash()
    {
        return $this->sigPolicyHash;
    }

    /**
     * Sets a new sigPolicyHash
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $sigPolicyHash
     * @return self
     */
    public function setSigPolicyHash(\Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $sigPolicyHash)
    {
        $this->sigPolicyHash = $sigPolicyHash;
        return $this;
    }

    /**
     * Adds as sigPolicyQualifier
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $sigPolicyQualifier
     */
    public function addToSigPolicyQualifiers(\Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $sigPolicyQualifier)
    {
        $this->sigPolicyQualifiers[] = $sigPolicyQualifier;
        return $this;
    }

    /**
     * isset sigPolicyQualifiers
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSigPolicyQualifiers($index)
    {
        return isset($this->sigPolicyQualifiers[$index]);
    }

    /**
     * unset sigPolicyQualifiers
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSigPolicyQualifiers($index)
    {
        unset($this->sigPolicyQualifiers[$index]);
    }

    /**
     * Gets as sigPolicyQualifiers
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[]
     */
    public function getSigPolicyQualifiers()
    {
        return $this->sigPolicyQualifiers;
    }

    /**
     * Sets a new sigPolicyQualifiers
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $sigPolicyQualifiers
     * @return self
     */
    public function setSigPolicyQualifiers(array $sigPolicyQualifiers)
    {
        $this->sigPolicyQualifiers = $sigPolicyQualifiers;
        return $this;
    }


}

