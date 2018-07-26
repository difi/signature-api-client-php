<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing UnsignedSignaturePropertiesType
 *
 *
 * XSD Type: UnsignedSignaturePropertiesType
 */
class UnsignedSignaturePropertiesType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CounterSignatureType[] $counterSignature
     */
    private $counterSignature = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $signatureTimeStamp
     */
    private $signatureTimeStamp = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType[] $completeCertificateRefs
     */
    private $completeCertificateRefs = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType[] $completeRevocationRefs
     */
    private $completeRevocationRefs = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType[] $attributeCertificateRefs
     */
    private $attributeCertificateRefs = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType[] $attributeRevocationRefs
     */
    private $attributeRevocationRefs = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $sigAndRefsTimeStamp
     */
    private $sigAndRefsTimeStamp = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $refsOnlyTimeStamp
     */
    private $refsOnlyTimeStamp = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType[] $certificateValues
     */
    private $certificateValues = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType[] $revocationValues
     */
    private $revocationValues = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType[] $attrAuthoritiesCertValues
     */
    private $attrAuthoritiesCertValues = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType[] $attributeRevocationValues
     */
    private $attributeRevocationValues = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $archiveTimeStamp
     */
    private $archiveTimeStamp = array(
        
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
     * Adds as counterSignature
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CounterSignatureType $counterSignature
     */
    public function addToCounterSignature(\Digipost\Signature\API\XML\Thirdparty\XAdES\CounterSignatureType $counterSignature)
    {
        $this->counterSignature[] = $counterSignature;
        return $this;
    }

    /**
     * isset counterSignature
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCounterSignature($index)
    {
        return isset($this->counterSignature[$index]);
    }

    /**
     * unset counterSignature
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCounterSignature($index)
    {
        unset($this->counterSignature[$index]);
    }

    /**
     * Gets as counterSignature
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CounterSignatureType[]
     */
    public function getCounterSignature()
    {
        return $this->counterSignature;
    }

    /**
     * Sets a new counterSignature
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CounterSignatureType[] $counterSignature
     * @return self
     */
    public function setCounterSignature(array $counterSignature)
    {
        $this->counterSignature = $counterSignature;
        return $this;
    }

    /**
     * Adds as signatureTimeStamp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $signatureTimeStamp
     */
    public function addToSignatureTimeStamp(\Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $signatureTimeStamp)
    {
        $this->signatureTimeStamp[] = $signatureTimeStamp;
        return $this;
    }

    /**
     * isset signatureTimeStamp
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSignatureTimeStamp($index)
    {
        return isset($this->signatureTimeStamp[$index]);
    }

    /**
     * unset signatureTimeStamp
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSignatureTimeStamp($index)
    {
        unset($this->signatureTimeStamp[$index]);
    }

    /**
     * Gets as signatureTimeStamp
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[]
     */
    public function getSignatureTimeStamp()
    {
        return $this->signatureTimeStamp;
    }

    /**
     * Sets a new signatureTimeStamp
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $signatureTimeStamp
     * @return self
     */
    public function setSignatureTimeStamp(array $signatureTimeStamp)
    {
        $this->signatureTimeStamp = $signatureTimeStamp;
        return $this;
    }

    /**
     * Adds as completeCertificateRefs
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType $completeCertificateRefs
     */
    public function addToCompleteCertificateRefs(\Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType $completeCertificateRefs)
    {
        $this->completeCertificateRefs[] = $completeCertificateRefs;
        return $this;
    }

    /**
     * isset completeCertificateRefs
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCompleteCertificateRefs($index)
    {
        return isset($this->completeCertificateRefs[$index]);
    }

    /**
     * unset completeCertificateRefs
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCompleteCertificateRefs($index)
    {
        unset($this->completeCertificateRefs[$index]);
    }

    /**
     * Gets as completeCertificateRefs
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType[]
     */
    public function getCompleteCertificateRefs()
    {
        return $this->completeCertificateRefs;
    }

    /**
     * Sets a new completeCertificateRefs
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType[] $completeCertificateRefs
     * @return self
     */
    public function setCompleteCertificateRefs(array $completeCertificateRefs)
    {
        $this->completeCertificateRefs = $completeCertificateRefs;
        return $this;
    }

    /**
     * Adds as completeRevocationRefs
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType $completeRevocationRefs
     */
    public function addToCompleteRevocationRefs(\Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType $completeRevocationRefs)
    {
        $this->completeRevocationRefs[] = $completeRevocationRefs;
        return $this;
    }

    /**
     * isset completeRevocationRefs
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCompleteRevocationRefs($index)
    {
        return isset($this->completeRevocationRefs[$index]);
    }

    /**
     * unset completeRevocationRefs
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCompleteRevocationRefs($index)
    {
        unset($this->completeRevocationRefs[$index]);
    }

    /**
     * Gets as completeRevocationRefs
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType[]
     */
    public function getCompleteRevocationRefs()
    {
        return $this->completeRevocationRefs;
    }

    /**
     * Sets a new completeRevocationRefs
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType[] $completeRevocationRefs
     * @return self
     */
    public function setCompleteRevocationRefs(array $completeRevocationRefs)
    {
        $this->completeRevocationRefs = $completeRevocationRefs;
        return $this;
    }

    /**
     * Adds as attributeCertificateRefs
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType $attributeCertificateRefs
     */
    public function addToAttributeCertificateRefs(\Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType $attributeCertificateRefs)
    {
        $this->attributeCertificateRefs[] = $attributeCertificateRefs;
        return $this;
    }

    /**
     * isset attributeCertificateRefs
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetAttributeCertificateRefs($index)
    {
        return isset($this->attributeCertificateRefs[$index]);
    }

    /**
     * unset attributeCertificateRefs
     *
     * @param scalar $index
     * @return void
     */
    public function unsetAttributeCertificateRefs($index)
    {
        unset($this->attributeCertificateRefs[$index]);
    }

    /**
     * Gets as attributeCertificateRefs
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType[]
     */
    public function getAttributeCertificateRefs()
    {
        return $this->attributeCertificateRefs;
    }

    /**
     * Sets a new attributeCertificateRefs
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteCertificateRefsType[] $attributeCertificateRefs
     * @return self
     */
    public function setAttributeCertificateRefs(array $attributeCertificateRefs)
    {
        $this->attributeCertificateRefs = $attributeCertificateRefs;
        return $this;
    }

    /**
     * Adds as attributeRevocationRefs
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType $attributeRevocationRefs
     */
    public function addToAttributeRevocationRefs(\Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType $attributeRevocationRefs)
    {
        $this->attributeRevocationRefs[] = $attributeRevocationRefs;
        return $this;
    }

    /**
     * isset attributeRevocationRefs
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetAttributeRevocationRefs($index)
    {
        return isset($this->attributeRevocationRefs[$index]);
    }

    /**
     * unset attributeRevocationRefs
     *
     * @param scalar $index
     * @return void
     */
    public function unsetAttributeRevocationRefs($index)
    {
        unset($this->attributeRevocationRefs[$index]);
    }

    /**
     * Gets as attributeRevocationRefs
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType[]
     */
    public function getAttributeRevocationRefs()
    {
        return $this->attributeRevocationRefs;
    }

    /**
     * Sets a new attributeRevocationRefs
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CompleteRevocationRefsType[] $attributeRevocationRefs
     * @return self
     */
    public function setAttributeRevocationRefs(array $attributeRevocationRefs)
    {
        $this->attributeRevocationRefs = $attributeRevocationRefs;
        return $this;
    }

    /**
     * Adds as sigAndRefsTimeStamp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $sigAndRefsTimeStamp
     */
    public function addToSigAndRefsTimeStamp(\Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $sigAndRefsTimeStamp)
    {
        $this->sigAndRefsTimeStamp[] = $sigAndRefsTimeStamp;
        return $this;
    }

    /**
     * isset sigAndRefsTimeStamp
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSigAndRefsTimeStamp($index)
    {
        return isset($this->sigAndRefsTimeStamp[$index]);
    }

    /**
     * unset sigAndRefsTimeStamp
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSigAndRefsTimeStamp($index)
    {
        unset($this->sigAndRefsTimeStamp[$index]);
    }

    /**
     * Gets as sigAndRefsTimeStamp
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[]
     */
    public function getSigAndRefsTimeStamp()
    {
        return $this->sigAndRefsTimeStamp;
    }

    /**
     * Sets a new sigAndRefsTimeStamp
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $sigAndRefsTimeStamp
     * @return self
     */
    public function setSigAndRefsTimeStamp(array $sigAndRefsTimeStamp)
    {
        $this->sigAndRefsTimeStamp = $sigAndRefsTimeStamp;
        return $this;
    }

    /**
     * Adds as refsOnlyTimeStamp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $refsOnlyTimeStamp
     */
    public function addToRefsOnlyTimeStamp(\Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $refsOnlyTimeStamp)
    {
        $this->refsOnlyTimeStamp[] = $refsOnlyTimeStamp;
        return $this;
    }

    /**
     * isset refsOnlyTimeStamp
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetRefsOnlyTimeStamp($index)
    {
        return isset($this->refsOnlyTimeStamp[$index]);
    }

    /**
     * unset refsOnlyTimeStamp
     *
     * @param scalar $index
     * @return void
     */
    public function unsetRefsOnlyTimeStamp($index)
    {
        unset($this->refsOnlyTimeStamp[$index]);
    }

    /**
     * Gets as refsOnlyTimeStamp
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[]
     */
    public function getRefsOnlyTimeStamp()
    {
        return $this->refsOnlyTimeStamp;
    }

    /**
     * Sets a new refsOnlyTimeStamp
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $refsOnlyTimeStamp
     * @return self
     */
    public function setRefsOnlyTimeStamp(array $refsOnlyTimeStamp)
    {
        $this->refsOnlyTimeStamp = $refsOnlyTimeStamp;
        return $this;
    }

    /**
     * Adds as certificateValues
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType $certificateValues
     */
    public function addToCertificateValues(\Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType $certificateValues)
    {
        $this->certificateValues[] = $certificateValues;
        return $this;
    }

    /**
     * isset certificateValues
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCertificateValues($index)
    {
        return isset($this->certificateValues[$index]);
    }

    /**
     * unset certificateValues
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCertificateValues($index)
    {
        unset($this->certificateValues[$index]);
    }

    /**
     * Gets as certificateValues
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType[]
     */
    public function getCertificateValues()
    {
        return $this->certificateValues;
    }

    /**
     * Sets a new certificateValues
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType[] $certificateValues
     * @return self
     */
    public function setCertificateValues(array $certificateValues)
    {
        $this->certificateValues = $certificateValues;
        return $this;
    }

    /**
     * Adds as revocationValues
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType $revocationValues
     */
    public function addToRevocationValues(\Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType $revocationValues)
    {
        $this->revocationValues[] = $revocationValues;
        return $this;
    }

    /**
     * isset revocationValues
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetRevocationValues($index)
    {
        return isset($this->revocationValues[$index]);
    }

    /**
     * unset revocationValues
     *
     * @param scalar $index
     * @return void
     */
    public function unsetRevocationValues($index)
    {
        unset($this->revocationValues[$index]);
    }

    /**
     * Gets as revocationValues
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType[]
     */
    public function getRevocationValues()
    {
        return $this->revocationValues;
    }

    /**
     * Sets a new revocationValues
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType[] $revocationValues
     * @return self
     */
    public function setRevocationValues(array $revocationValues)
    {
        $this->revocationValues = $revocationValues;
        return $this;
    }

    /**
     * Adds as attrAuthoritiesCertValues
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType $attrAuthoritiesCertValues
     */
    public function addToAttrAuthoritiesCertValues(\Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType $attrAuthoritiesCertValues)
    {
        $this->attrAuthoritiesCertValues[] = $attrAuthoritiesCertValues;
        return $this;
    }

    /**
     * isset attrAuthoritiesCertValues
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetAttrAuthoritiesCertValues($index)
    {
        return isset($this->attrAuthoritiesCertValues[$index]);
    }

    /**
     * unset attrAuthoritiesCertValues
     *
     * @param scalar $index
     * @return void
     */
    public function unsetAttrAuthoritiesCertValues($index)
    {
        unset($this->attrAuthoritiesCertValues[$index]);
    }

    /**
     * Gets as attrAuthoritiesCertValues
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType[]
     */
    public function getAttrAuthoritiesCertValues()
    {
        return $this->attrAuthoritiesCertValues;
    }

    /**
     * Sets a new attrAuthoritiesCertValues
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CertificateValuesType[] $attrAuthoritiesCertValues
     * @return self
     */
    public function setAttrAuthoritiesCertValues(array $attrAuthoritiesCertValues)
    {
        $this->attrAuthoritiesCertValues = $attrAuthoritiesCertValues;
        return $this;
    }

    /**
     * Adds as attributeRevocationValues
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType $attributeRevocationValues
     */
    public function addToAttributeRevocationValues(\Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType $attributeRevocationValues)
    {
        $this->attributeRevocationValues[] = $attributeRevocationValues;
        return $this;
    }

    /**
     * isset attributeRevocationValues
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetAttributeRevocationValues($index)
    {
        return isset($this->attributeRevocationValues[$index]);
    }

    /**
     * unset attributeRevocationValues
     *
     * @param scalar $index
     * @return void
     */
    public function unsetAttributeRevocationValues($index)
    {
        unset($this->attributeRevocationValues[$index]);
    }

    /**
     * Gets as attributeRevocationValues
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType[]
     */
    public function getAttributeRevocationValues()
    {
        return $this->attributeRevocationValues;
    }

    /**
     * Sets a new attributeRevocationValues
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\RevocationValuesType[] $attributeRevocationValues
     * @return self
     */
    public function setAttributeRevocationValues(array $attributeRevocationValues)
    {
        $this->attributeRevocationValues = $attributeRevocationValues;
        return $this;
    }

    /**
     * Adds as archiveTimeStamp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $archiveTimeStamp
     */
    public function addToArchiveTimeStamp(\Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $archiveTimeStamp)
    {
        $this->archiveTimeStamp[] = $archiveTimeStamp;
        return $this;
    }

    /**
     * isset archiveTimeStamp
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetArchiveTimeStamp($index)
    {
        return isset($this->archiveTimeStamp[$index]);
    }

    /**
     * unset archiveTimeStamp
     *
     * @param scalar $index
     * @return void
     */
    public function unsetArchiveTimeStamp($index)
    {
        unset($this->archiveTimeStamp[$index]);
    }

    /**
     * Gets as archiveTimeStamp
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[]
     */
    public function getArchiveTimeStamp()
    {
        return $this->archiveTimeStamp;
    }

    /**
     * Sets a new archiveTimeStamp
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $archiveTimeStamp
     * @return self
     */
    public function setArchiveTimeStamp(array $archiveTimeStamp)
    {
        $this->archiveTimeStamp = $archiveTimeStamp;
        return $this;
    }


}

