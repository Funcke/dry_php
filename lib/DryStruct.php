<?php

namespace Dry;
use Dry\Schema\Property;
use Dry\Schema\ObjectProperty;
use Dry\Schema\ArrayProperty;
use Dry\Exception\InvalidSchemaException;

/**
 * Class DryStruct
 * @package Dry
 *
 * DryStruct represents the entry Node for a Dry::PHP structure. It is being
 * used to provide a clean and reusable builder pattern to create schemas
 * which are not only easy to build but also easy to evaluate.
 */
class DryStruct 
{
  protected $required;
  protected $optional;
  protected $checked;
  protected $additional;

    /**
     * DryStruct constructor.
     * default c'tor
     */
  protected function __construct() {
    $this->required = [];
    $this->optional = [];
    $this->checked = [];
    $this->additional = [];
  }

    /**
     * Adds a new property to the list of required properties.
     *
     * @param $name string - identifier for the property to evaluate
     * @return Property - configurable instance of Dry::Schema::Property
     */
  protected function &required($name) 
  {
    $this->required[$name] = new Property();
    return $this->required[$name];
  }

    /**
     * Adds optional field to the property array.
     * @param $name string
     * @return mixed
     */
  protected function &optional($name) 
  {
    $this->optional[$name] = new Property();
    return $this->optional[$name];
  }

    /**
     * Adds required object field to property array.
     * @param $name string
     * @return mixed
     */
  protected function &required_object($name)
  {
    $this->required[$name] = new ObjectProperty();
    return $this->required[$name];
  }

    /**
     * Adds optional object field to property array.
     * @param $name string
     * @return mixed
     */
  protected function &optional_object($name)
  {
    $this->optional[$name] = new ObjectProperty();
    return $this->requried[$name];
  }

    /**
     * Adds required array field to property array.
     * @param $name string
     * @return mixed
     */
  protected function &required_array($name)
  {
    $this->required[$name] = new ArrayProperty();
    return $this->required[$name];
  }

    /**
     * Adds optional array field to property array.
     * @param $name string
     * @return mixed
     */
  protected function &optional_array($name)
  {
    $this->optional[$name] = new ArrayProperty();
    return $this->requried[$name];
  }

    /**
     * Checks if provided data structure fulfills all requirements previously defined.
     * @param $model mixed
     * @throws InvalidSchemaException
     */
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

    /**
     * Checks all fields in model against the required property array.
     * @param $model mixed
     * @throws InvalidSchemaException
     */
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

    /**
     * Checks all fields in model against optional property array.
     * @param $model mixed
     */
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

    /**
     * Checks if the provided schema does not contain any additional fields.
     * @param $model mixed
     * @return bool - true if the model contains more fields than specified in the constraints
     */
  private function contains_additional($model)
  {
    $this->additional = array_diff(array_keys($model), array_merge(array_keys($this->optional), array_keys($this->required)));
    return !empty($this->additional);
  }
}