<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

/**
 * Class representing ExtensionType
 *
 *
 * XSD Type: ExtensionType
 */
class ExtensionType extends AnyType
{

    /**
     * @property boolean $critical
     */
    private $critical = null;

    /**
     * Gets as critical
     *
     * @return boolean
     */
    public function getCritical()
    {
        return $this->critical;
    }

    /**
     * Sets a new critical
     *
     * @param boolean $critical
     * @return self
     */
    public function setCritical($critical)
    {
        $this->critical = $critical;
        return $this;
    }


}

