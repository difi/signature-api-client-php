<?php

namespace Digipost\Signature\Client\Core\Internal;

interface XMLCryptoContext {

  function getBaseURI(): String;

  function setBaseURI(String $var1);

  function getKeySelector(): KeySelector;

  function setKeySelector(KeySelector $var1);

  function getURIDereferencer(): URIDereferencer;

  function setURIDereferencer(URIDereferencer $var1);

  function getNamespacePrefix(String $var1, String $var2): String;

  function putNamespacePrefix(String $var1, String $var2);

  function getDefaultNamespacePrefix(): String;

  function setDefaultNamespacePrefix(String $var1);

  function setProperty(String $var1, Object $var2): Object;

  function getProperty(String $var1): Object;

  function get(Object $var1): Object;

  function put(Object $var1, Object $var2): Object;
}
