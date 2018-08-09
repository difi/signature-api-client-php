<?php

namespace Digipost\Signature\Client\Portal;

use MyCLabs\Enum\Enum;

/**
 * @method static TimeUnit SECONDS()
 * @method static TimeUnit MINUTES()
 * @method static TimeUnit HOURS()
 * @method static TimeUnit DAYS()
 * @method static TimeUnit MONTHS()
 * @method static TimeUnit YEARS()
 */
class TimeUnit extends Enum {
  const SECONDS = 'SECONDS';
  const MINUTES = 'MINUTES';
  const HOURS = 'HOURS';
  const DAYS = 'DAYS';
  const MONTHS = 'MONTHS';
  const YEARS = 'YEARS';

  /** @var int */
  private $seconds;

  public function __construct($value) {
    parent::__construct($value);
    $this->seconds = strtotime('2 ' . $value, 0) / 2;
  }

  public function toSeconds(int $seconds) {
    return $this->seconds * $seconds;
  }
}