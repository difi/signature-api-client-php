<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing NoticeReferenceType
 *
 *
 * XSD Type: NoticeReferenceType
 */
class NoticeReferenceType
{

    /**
     * @property string $organization
     */
    private $organization = null;

    /**
     * @property integer[] $noticeNumbers
     */
    private $noticeNumbers = null;

    /**
     * Gets as organization
     *
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Sets a new organization
     *
     * @param string $organization
     * @return self
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * Adds as int
     *
     * @return self
     * @param integer $int
     */
    public function addToNoticeNumbers($int)
    {
        $this->noticeNumbers[] = $int;
        return $this;
    }

    /**
     * isset noticeNumbers
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetNoticeNumbers($index)
    {
        return isset($this->noticeNumbers[$index]);
    }

    /**
     * unset noticeNumbers
     *
     * @param scalar $index
     * @return void
     */
    public function unsetNoticeNumbers($index)
    {
        unset($this->noticeNumbers[$index]);
    }

    /**
     * Gets as noticeNumbers
     *
     * @return integer[]
     */
    public function getNoticeNumbers()
    {
        return $this->noticeNumbers;
    }

    /**
     * Sets a new noticeNumbers
     *
     * @param integer[] $noticeNumbers
     * @return self
     */
    public function setNoticeNumbers(array $noticeNumbers)
    {
        $this->noticeNumbers = $noticeNumbers;
        return $this;
    }


}

