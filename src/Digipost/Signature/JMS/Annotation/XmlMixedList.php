<?php
namespace Digipost\Signature\JMS\Annotation;

use JMS\Serializer\Annotation\XmlCollection;

/**
 * @Annotation
 * @Target({"PROPERTY","METHOD","ANNOTATION"})
 */
final class XmlMixedList extends XmlCollection
{
  /**
   * @var array
   */
  public $entry = 'entry';
}
