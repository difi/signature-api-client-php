<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing SPKIDataType
 *
 *
 * XSD Type: SPKIDataType
 */
class SPKIDataType
{

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType[] $sPKISexp
     */
    private $sPKISexp = array(
        
    );

    /**
     * Adds as sPKISexp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $sPKISexp
     */
    public function addToSPKISexp(\Digipost\Signature\API\XML\CustomBase64BinaryType $sPKISexp)
    {
        $this->sPKISexp[] = $sPKISexp;
        return $this;
    }

    /**
     * isset sPKISexp
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSPKISexp($index)
    {
        return isset($this->sPKISexp[$index]);
    }

    /**
     * unset sPKISexp
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSPKISexp($index)
    {
        unset($this->sPKISexp[$index]);
    }

    /**
     * Gets as sPKISexp
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType[]
     */
    public function getSPKISexp()
    {
        return $this->sPKISexp;
    }

    /**
     * Sets a new sPKISexp
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType[] $sPKISexp
     * @return self
     */
    public function setSPKISexp(array $sPKISexp)
    {
        $this->sPKISexp = $sPKISexp;
        return $this;
    }


}

