<?php
namespace Digipost\Signature\JMS\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;
use JMS\Serializer\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY","METHOD","ANNOTATION"})
 * @author Bendik R: Brenne <bendik@konstant.no>
 */
final class XmlElementRef {

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $namespace = '';

  /**
   * @var string
   */
  public $type;

  /**
   * @var bool
   */
  public $required = FALSE;

  public function __construct(array $data) {
    if (isset($data['value'])) {
      $data['name'] = $data['value'];
      unset($data['value']);
    }
    foreach ($data as $key => $value) {
      if (!property_exists(self::class, $key)) {
        throw new \BadMethodCallException(sprintf('Unknown property "%s" on annotation "%s".',
                                                  $key, __CLASS__));
      }
      $this->{$key} = $value;
    }
    $test = $this->type;
  }
}

