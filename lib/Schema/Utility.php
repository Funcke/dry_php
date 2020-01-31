<?php

namespace Dry\Schema;

use Dry\Exception\InvalidSchemaException;
trait Utility {
public static function methods(){
    return [
    "type" => function ($constraint, $value) { 
      if(gettype($value) !== $constraint) 
        throw new InvalidSchemaException(
        $value, 
        "Invalid type ". gettype($value) . "! " . $constraint . " expected."
      );
    },
    "max" => function ($constraint, $value) { if($value > $constraint) throw new InvalidSchemaException($value); },
    "min" => function ($constraint, $value) { if($value < $constraint) throw new InvalidSchemaException($value); },
    "minLength" => function ($constraint, $value) { if(strlen($value) < $constraint) throw new InvalidSchemaException($value); },
    "maxLength" => function ($constraint, $value) { if(strlen($value) > $constraint) throw new InvalidSchemaException($value); },
    "format" => function ($constraint, $value) { if(!preg_match($constraint, $value)) throw new InvalidSchemaException($value); },
    "minSize" => function ($constraint, $value) { if(count($value) < $constraint) throw new InvalidSchemaException($value); },
    "maxSize" => function ($constraint, $value) { if(count($value) > $constraint) throw new InvalidSchemaException($value); },
    "notEmpty" => function($constraint, $value) { if(empty($value)) throw new InvalidSchemaException($value); },
    "notNull" => function($constraint, $value) { if($value === NULL) throw new InvalidSchemaException($value); }
  ];
}
}