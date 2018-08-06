<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing SignerRoleType
 *
 *
 * XSD Type: SignerRoleType
 */
class SignerRoleType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $claimedRoles
     */
    private $claimedRoles = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $certifiedRoles
     */
    private $certifiedRoles = null;

    /**
     * Adds as claimedRole
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $claimedRole
     */
    public function addToClaimedRoles(\Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $claimedRole)
    {
        $this->claimedRoles[] = $claimedRole;
        return $this;
    }

    /**
     * isset claimedRoles
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetClaimedRoles($index)
    {
        return isset($this->claimedRoles[$index]);
    }

    /**
     * unset claimedRoles
     *
     * @param string|number $index
     * @return void
     */
    public function unsetClaimedRoles($index)
    {
        unset($this->claimedRoles[$index]);
    }

    /**
     * Gets as claimedRoles
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[]
     */
    public function getClaimedRoles()
    {
        return $this->claimedRoles;
    }

    /**
     * Sets a new claimedRoles
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $claimedRoles
     * @return self
     */
    public function setClaimedRoles(array $claimedRoles)
    {
        $this->claimedRoles = $claimedRoles;
        return $this;
    }

    /**
     * Adds as certifiedRole
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $certifiedRole
     */
    public function addToCertifiedRoles(\Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $certifiedRole)
    {
        $this->certifiedRoles[] = $certifiedRole;
        return $this;
    }

    /**
     * isset certifiedRoles
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetCertifiedRoles($index)
    {
        return isset($this->certifiedRoles[$index]);
    }

    /**
     * unset certifiedRoles
     *
     * @param string|number $index
     * @return void
     */
    public function unsetCertifiedRoles($index)
    {
        unset($this->certifiedRoles[$index]);
    }

    /**
     * Gets as certifiedRoles
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[]
     */
    public function getCertifiedRoles()
    {
        return $this->certifiedRoles;
    }

    /**
     * Sets a new certifiedRoles
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $certifiedRoles
     * @return self
     */
    public function setCertifiedRoles(array $certifiedRoles)
    {
        $this->certifiedRoles = $certifiedRoles;
        return $this;
    }


}

