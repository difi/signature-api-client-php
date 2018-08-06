<?php

namespace Digipost\Signature\Client\Core\Internal;

interface XMLCryptoContext {

  function getBaseURI(): String;

  function setBaseURI(String $var1);

  //function getKeySelector(): KeySelector;
  //function setKeySelector(KeySelector $var1);
  //function getURIDereferencer(): URIDereferencer;
  //function setURIDereferencer(URIDereferencer $var1);

  function getNamespacePrefix(String $var1, String $var2): String;

  function putNamespacePrefix(String $var1, String $var2);

  function getDefaultNamespacePrefix(): String;

  function setDefaultNamespacePrefix(String $var1);

  function setProperty(String $var1, $var2);

  function getProperty(String $var1);

  function get($var1);

  function put($var1, $var2);
}
