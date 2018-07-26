<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing SPUserNoticeType
 *
 *
 * XSD Type: SPUserNoticeType
 */
class SPUserNoticeType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\NoticeReferenceType $noticeRef
     */
    private $noticeRef = null;

    /**
     * @property string $explicitText
     */
    private $explicitText = null;

    /**
     * Gets as noticeRef
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\NoticeReferenceType
     */
    public function getNoticeRef()
    {
        return $this->noticeRef;
    }

    /**
     * Sets a new noticeRef
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\NoticeReferenceType $noticeRef
     * @return self
     */
    public function setNoticeRef(\Digipost\Signature\API\XML\Thirdparty\XAdES\NoticeReferenceType $noticeRef)
    {
        $this->noticeRef = $noticeRef;
        return $this;
    }

    /**
     * Gets as explicitText
     *
     * @return string
     */
    public function getExplicitText()
    {
        return $this->explicitText;
    }

    /**
     * Sets a new explicitText
     *
     * @param string $explicitText
     * @return self
     */
    public function setExplicitText($explicitText)
    {
        $this->explicitText = $explicitText;
        return $this;
    }


}

