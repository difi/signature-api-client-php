<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing CompleteCertificateRefsType
 *
 *
 * XSD Type: CompleteCertificateRefsType
 */
class CompleteCertificateRefsType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType[] $certRefs
     */
    private $certRefs = null;

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
     * Adds as cert
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType $cert
     */
    public function addToCertRefs(\Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType $cert)
    {
        $this->certRefs[] = $cert;
        return $this;
    }

    /**
     * isset certRefs
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCertRefs($index)
    {
        return isset($this->certRefs[$index]);
    }

    /**
     * unset certRefs
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCertRefs($index)
    {
        unset($this->certRefs[$index]);
    }

    /**
     * Gets as certRefs
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType[]
     */
    public function getCertRefs()
    {
        return $this->certRefs;
    }

    /**
     * Sets a new certRefs
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType[] $certRefs
     * @return self
     */
    public function setCertRefs(array $certRefs)
    {
        $this->certRefs = $certRefs;
        return $this;
    }


}

