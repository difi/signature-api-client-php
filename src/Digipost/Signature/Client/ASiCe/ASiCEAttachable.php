<?php
namespace Digipost\Signature\Client\ASiCe;

interface ASiCEAttachable {
  /**
   * @return string
   */
  function getFileName();

  /**
   * @return string
   */
  function getBytes();

  /**
   * @return string
   */
  function getMimeType();
}