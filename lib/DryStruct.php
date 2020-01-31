<?php

namespace Dry;
use Dry\Schema\Property;
use Dry\Schema\ObjectProperty;
use Dry\Exception\InvalidSchemaException;
class DryStruct 
{
  protected $required;
  protected $optional;
  protected $checked;
  protected $additional;
  protected function __construct() {
    $this->required = [];
    $this->optional = [];
    $this->checked = [];
    $this->additional = [];
  }

  protected function &required($name) 
  {
    $this->required[$name] = new Property();
    return $this->required[$name];
  }

  protected function &optional($name) 
  {
    $this->optional[$name] = new Property();
    return $this->optional[$name];
  }

  protected function &required_object($name)
  {
    $this->required[$name] = new ObjectProperty();
    return $this->required[$name];
  }

  protected function &optional_object($name)
  {
    $this->optional[$name] = new ObjectProperty();
    return $this->requried[$name];
  }

  protected function &required_array($name)
  {
    $this->required[$name] = new ArrayProperty();
    return $this->requried[$name];
  }

  protected function &optional_array($name)
  {
    $this->optional[$name] = new ArrayProperty();
    return $this->requried[$name];
  }

  public function validate($model)
  {
    $clone = (array) $model;
    self::validate_required($clone);
    self::validate_optional($clone);
    if(self::contains_additional($clone))
    {
      throw new InvalidSchemaException(implode(',', $this->additional));
    }
  }

  private function validate_required($model)
  {
    foreach($this->required as $key => $validation)
    {
      if(array_key_exists($key, $model))
      {
        $validation->validate($model[$key]);
        array_push($this->checked, $key);
      } else {
        throw new InvalidSchemaException($key);
      }
    }
  }

  private function validate_optional($model)
  {
    foreach($this->optional as $key => $validation)
    {
      if(array_key_exists($key, $model))
      {
        $validation->validate($model[$key]);
        array_push($this->checked, $key);
      }
    }
  }

  private function contains_additional($model)
  {
    $this->additional = array_diff(array_keys($model), array_merge(array_keys($this->optional), array_keys($this->required)));
    return !empty($this->additional);
  }
}