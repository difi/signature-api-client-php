<?php
namespace Digipost\Signature\API\XML;

use MyCLabs\Enum\Enum;

/**
 * Class XMLAuthenticationLevel
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * ```xml
 * <simpleType name="authentication-level">
 *   <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *     <enumeration value="3"/>
 *     <enumeration value="4"/>
 *   </restriction>
 * </simpleType>
 * ```
 *
 * @package Digipost\Signature\API\XML
 */
class XMLAuthenticationLevel extends Enum {
  const THREE = "3";
  const FOUR = "4";
}
