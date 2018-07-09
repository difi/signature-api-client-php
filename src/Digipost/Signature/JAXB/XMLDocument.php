<?php

namespace Digipost\Signature\JAXB;

interface XMLDocument {

  function getTitle(): String;

  function getDescription(): String;

  function getHref(): String;

  function getMime(): String;
}
