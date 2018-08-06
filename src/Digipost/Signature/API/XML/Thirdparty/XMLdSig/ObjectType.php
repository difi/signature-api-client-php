<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use Digipost\Signature\Client\Core\Internal\XML\XMLStructure;
use Doctrine\Common\Proxy\ProxyDefinition;

/**
 * Class representing ObjectType
 *
 *
 * XSD Type: ObjectType
 */
class ObjectType
{

  /** @var XMLStructure[] $content */
    private $content = [];

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property string $mimeType
     */
    private $mimeType = null;

    /**
     * @property string $encoding
     */
    private $encoding = null;

  /**
   * @var XMLStructure
   */
    private $proxy;

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
     * Gets as mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Sets a new mimeType
     *
     * @param string $mimeType
     * @return self
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * Gets as encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Sets a new encoding
     *
     * @param string $encoding
     * @return self
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }

  /**
   * @return XMLStructure[]
   */
  public function getContent(){
    return $this->content;
  }

  /**
   * @param array $content
   * @return ObjectType
   */
  public function setContent($content)
  {
    $this->content = array_map($cb = function($c) use (&$cb) {
      if (is_array($c)) {
        return array_map($cb, $c);
      }
      if ($c instanceof XMLStructure) {
        return $c->getContent();
      }
      return $c;
    }, $content);
    return $this;
  }
}

