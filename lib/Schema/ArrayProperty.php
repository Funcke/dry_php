<?php

/**
 * ArrayProperty
 * 
 * PHP Version 7.3
 * 
 * Declaration of ArrayProperty class.
 * 
 * @category Class
 * @package  Dry\Schema
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */

namespace Dry\Schema;

use Dry\Schema\ObjectProperty;

/**
 * ArrayProperty
 * 
 * ArrayProperty represents a property with the type array.
 * It enables developers to define constraints for the data stored
 * in the array.
 * 
 * @category Class
 * @package  Dry\Schema
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */
class ArrayProperty
{
    /**
     * The contstraint definition for
     * the data included in the array.
     * 
     * @var Dry\Schema\Property
     */
    private $_element;

    /**
     * Default c'tor
     */
    public function __construct()
    {
        ;
    }

    /**
     * Initializes the type of property included in the defined
     * ArrayProperty.
     * 
     * @param $type string
     * 
     * @return Property - the element defined
     */
    public function type($type)
    {
        if ($type === 'object') {
            $this->_element = new ObjectProperty();
        } else if ($type === 'array') {
            $this->_element = new ArrayProperty();
        } else {
            $this->_element = new Property();
        }

        return $this->_element;
    }

    /**
     * Calls the provided closure with the current object instance.
     * This method should be used to set constraints on the data included
     * in the array.
     * 
     * @param $function Closure
     * 
     * @return void
     */
    public function each($function)
    {
        $function($this);
    }

    /**
     * Validates the data passed against the defined constraints.
     * 
     * @param $value Array
     * 
     * @return Array Returns array with found violations
     */
    public function validate($value)
    {
        $violations = [];
        foreach ($value as $element) {
            $result = $this->_element->validate($element);
            if (!empty($result)) {
                array_push($violations, $result);
            }
        }
        return $violations;
    }
}
