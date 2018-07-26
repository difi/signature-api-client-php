<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing CertIDListType
 *
 *
 * XSD Type: CertIDListType
 */
class CertIDListType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType[] $cert
     */
    private $cert = array(
        
    );

    /**
     * Adds as cert
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType $cert
     */
    public function addToCert(\Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType $cert)
    {
        $this->cert[] = $cert;
        return $this;
    }

    /**
     * isset cert
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCert($index)
    {
        return isset($this->cert[$index]);
    }

    /**
     * unset cert
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCert($index)
    {
        unset($this->cert[$index]);
    }

    /**
     * Gets as cert
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType[]
     */
    public function getCert()
    {
        return $this->cert;
    }

    /**
     * Sets a new cert
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType[] $cert
     * @return self
     */
    public function setCert(array $cert)
    {
        $this->cert = $cert;
        return $this;
    }


}

