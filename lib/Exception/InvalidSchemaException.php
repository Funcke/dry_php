<?php

namespace Dry\Exception;

class InvalidSchemaException extends \Exception {
  public $Property;
  public function __construct($property_name, $message = "") {
    parent::__construct(empty($message) ? "Property not valid: ".$property_name : $message);
    $this->Property = $property_name;
  }
}