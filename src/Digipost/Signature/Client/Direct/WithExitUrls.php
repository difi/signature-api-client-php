<?php
namespace Digipost\Signature\Client\Direct;

interface WithExitUrls {

  function getCompletionUrl();

  function getRejectionUrl();

  function getErrorUrl();
}


