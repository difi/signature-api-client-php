<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing SignaturePolicyIdentifierType
 *
 *
 * XSD Type: SignaturePolicyIdentifierType
 */
class SignaturePolicyIdentifierType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\SignaturePolicyIdType $signaturePolicyId
     */
    private $signaturePolicyId = null;

    /**
     * @property \Digipost\Signature\API\XML\AnyType $signaturePolicyImplied
     */
    private $signaturePolicyImplied = null;

    /**
     * Gets as signaturePolicyId
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\SignaturePolicyIdType
     */
    public function getSignaturePolicyId()
    {
        return $this->signaturePolicyId;
    }

    /**
     * Sets a new signaturePolicyId
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\SignaturePolicyIdType $signaturePolicyId
     * @return self
     */
    public function setSignaturePolicyId(\Digipost\Signature\API\XML\Thirdparty\XAdES\SignaturePolicyIdType $signaturePolicyId)
    {
        $this->signaturePolicyId = $signaturePolicyId;
        return $this;
    }

    /**
     * Gets as signaturePolicyImplied
     *
     * @return \Digipost\Signature\API\XML\AnyType
     */
    public function getSignaturePolicyImplied()
    {
        return $this->signaturePolicyImplied;
    }

    /**
     * Sets a new signaturePolicyImplied
     *
     * @param \Digipost\Signature\API\XML\AnyType $signaturePolicyImplied
     * @return self
     */
    public function setSignaturePolicyImplied(\Digipost\Signature\API\XML\AnyType $signaturePolicyImplied)
    {
        $this->signaturePolicyImplied = $signaturePolicyImplied;
        return $this;
    }


}

