<?php

namespace Dofinity\SimpleRNG;

/**
 * Generates a random number using the PHP mt_rand function.
 */
class Generator {

  /**
   * The length of the generated number.
   *
   * @var int
   */
  private $length;

  /**
   * The generated number will be lower than the upper bound.
   *
   * @var int
   */
  private $upperBound;

  /**
   * Should the number be (left) padded with zeros.
   *
   * @var bool
   */
  private $padNumber;

  /**
   * Constructor for the Generator object.
   *
   * @param int $length
   *   The maximum length of the resulting number.
   * @param bool $padNumber
   *   Should the number be (left) padded with zeros.
   */
  private function __construct($length = 6, $padNumber = TRUE) {
    $this->length = $length;
    $this->max = pow(10, $this->length);
    $this->padNumber = $padNumber;
  }

  /**
   * Constructs and returns an instance of the Generator class.
   *
   * @param int $length
   *   The maximum length of the resulting number.
   * @param bool $padNumber
   *   Should the number be (left) padded with zeros.
   *
   * @throws \InvalidArgumentException
   *   If the length argument is not a valid integer larger than 0.
   *
   * @return \Dofinity\SimpleRNG\Generator
   *   An instance of the Generator class.
   */
  public static function create($length = 6, $padNumber = TRUE) {
    if (!is_numeric($length) || !is_int($length)) {
      throw new \InvalidArgumentException('Length must be a valid integer.');
    }
    if ($length < 1) {
      throw new \InvalidArgumentException('The length of the number cannot be smaller then 1');
    }

    return new static($length, (bool) $padNumber);
  }

  /**
   * @return string|int
   */
  public function generate() {
    $random_int = mt_rand(0, $this->max - 1);

    if ($this->padNumber) {
      return $this->pad($random_int);
    }

    return $random_int;
  }

  /**
   * To allow preceding zeros we add $max to the value, convert it to string and
   * remove the first character.
   * @param int $number
   * @return string
   */
  private function pad($number) {
    $value = $this->max + $number;
    $str_value = (string) $value;
    return substr($str_value, 1, $this->length);
  }

}
