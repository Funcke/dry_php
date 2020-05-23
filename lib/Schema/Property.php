<?php

namespace Dry\Schema;
use Dry\Schema\Utility;

/**
 * Class Property
 * @package Dry\Schema
 */
class Property 
{
    /**
     * @var array
     */
  private $structure = [];
  public function __construct()
  {
    ;
  }

  public function filled($type)
  {
    $this->structure['type'] = $type;
    return $this;
  }

  public function min($min)
  {
    $this->structure['min'] = $min;
    return $this;
  }

  public function max($max)
  {
    $this->structure['max'] = $max;
    return $this;
  }

  public function minLength($min)
  {
    $this->structure['minLength'] = $min;
    return $this;
  }

  public function maxLength($max)
  {
    $this->structure['maxLength'] = $max;
    return $this;
  }

  public function format($regex)
  {
    $this->structure['format'] = $regex;
    return $this;
  }

  public function notNull()
  {
    $this->structure['notNull'] = 1;
    return $this;
  }

  public function notEmpty()
  {
    $this->structure['notEmpty'] = 1;
    return $this;
  }

  public function validate($value)
  {
    foreach($this->structure as $method => $arg)
    {
      Utility::methods()[$method]($arg, $value);
    }
  }
}
