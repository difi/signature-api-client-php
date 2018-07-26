<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing CanonicalizationMethodType
 *
 *
 * XSD Type: CanonicalizationMethodType
 */
class CanonicalizationMethodType
{

    /**
     * @property string $algorithm
     */
    private $algorithm = null;

    /**
     * Gets as algorithm
     *
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Sets a new algorithm
     *
     * @param string $algorithm
     * @return self
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
        return $this;
    }


}

