<?php

namespace Dry\Schema;
use Dry\Schema\Utility;
use Dry\Exception\InvalidSchemaException;

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
    $violatedConstraints = [];
    foreach($this->structure as $method => $arg)
    {
      try{
        Utility::methods()[$method]($arg, $value);
      } catch (InvalidSchemaException $e) {
        array_push($violatedConstraints, $method);
      }
    }
    return $violatedConstraints;
  }
}
