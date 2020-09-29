<?php

/**
 * Property
 * 
 * PHP Version 7.3
 * 
 * Declaration of Property class.
 * 
 * @category Class
 * @package  Dry\Schema
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */

namespace Dry\Schema;
use Dry\Schema\Utility;
use Dry\Exception\InvalidSchemaException;

/**
 * Class Property
 *
 * Represents a schema property. Allows the developer to define
 * constraints on the property and provides an API to valdiate it.
 * 
 * @category Class
 * @package  Dry\Schema
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */
class Property
{
    /**
     * Array with constraints to call on the property.
     * 
     * @var array
     */
    private $_structure = [];

    /**
     * Default c'tor
     */
    public function __construct()
    {
        ;
    }

    /**
     * Defines the type of a property.
     * 
     * @param $type
     * 
     * @return Property
     */
    public function filled($type)
    {
        $this->_structure['type'] = $type;
        return $this;
    }

    /**
     * Defines min value for a property.
     * 
     * @param $min number
     * 
     * @return Property
     */
    public function min($min)
    {
        $this->_structure['min'] = $min;
        return $this;
    }

    /**
     * Defines max value for a property.
     * 
     * @param $max number
     * 
     * @return Property
     */
    public function max($max)
    {
        $this->_structure['max'] = $max;
        return $this;
    }

    /**
     * Defines minimum length for a string property.
     * 
     * @param $min int
     * 
     * @return Property
     */
    public function minLength($min)
    {
        $this->_structure['minLength'] = $min;
        return $this;
    }

    /**
     * Defines max length for a string property.
     * 
     * @param $max int
     * 
     * @return Property
     */
    public function maxLength($max)
    {
        $this->_structure['maxLength'] = $max;
        return $this;
    }

    /**
     * Define a format for a string property.
     * 
     * @param $regex Regexp
     * 
     * @return Property
     */
    public function format($regex)
    {
        $this->_structure['format'] = $regex;
        return $this;
    }

    /**
     * Defines not null constraint for property.
     * 
     * @return Property
     */
    public function notNull()
    {
        $this->_structure['notNull'] = 1;
        return $this;
    }

    /**
     * Defines not empty status for array property.
     * 
     * @return Property
     */
    public function notEmpty()
    {
        $this->_structure['notEmpty'] = 1;
        return $this;
    }

    /**
     * Validates the given data against the previously defined constraints.
     * 
     * @param $value Array|Object
     * 
     * @return Array
     */
    public function validate($value)
    {
        $violatedConstraints = [];
        foreach ($this->_structure as $method => $arg) {
            try {
                Utility::methods()[$method]($arg, $value);
            } catch (InvalidSchemaException $e) {
                array_push($violatedConstraints, $method);
            }
        }
        return $violatedConstraints;
    }
}
