<?php
namespace Digipost\Signature\JMS\Annotation;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 * @Target({"PROPERTY","METHOD","ANNOTATION"})
 * @Attributes({
 *   @Attribute("name", type="string"),
 *   @Attribute("values", type="array<Digipost\Signature\JMS\Annotation\XmlElementRef>")
 * })
 *
 * @author Bendik R: Brenne <bendik@konstant.no>
 */
final class XmlElementRefs {

  /**
   * @Required
   * @var string
   */
  public $name;

  /**
   * @Required
   * @var Digipost\Signature\JMS\Annotation\XmlElementRef[]
   */
  public $values;

  function __construct(array $values) {
    if (isset($values['value'])) {
      $values['name'] = $values['value'];
      unset($values['value']);
    }

    foreach ($values as $key => $value) {
      if (!property_exists(self::class, $key)) {

        throw new \BadMethodCallException(sprintf('Unknown property "%s" on annotation "%s".',
                                                  $key, __CLASS__));
      }
    }
    $this->name = $values['name'];
    $this->values = $values['values'];

    //print_r($values);

    //$this->refs = $values['refs'];
    //    foreach ($data as $key => $value) {
    //      $this->{$key} = $value;
    //    }
  }
}
