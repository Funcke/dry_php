<?php

/**
 * ObjectProperty
 * 
 * PHP Version 7.3
 * 
 * Declaration of ObjectProperty class.
 * 
 * @category Class
 * @package  Dry\Schema
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */

namespace Dry\Schema;

use Dry\DryStruct;

/**
 * Class ObjectProperty
 * 
 * Represents a property that is in itself a schema & enables
 * validation constraints for its properties.
 *
 * @category Class
 * @package  Dry\Schema
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */
class ObjectProperty extends DryStruct
{
    /**
     * Default c'tor
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Calls given closure on current object instance to 
     * enable developers to enable constraints for the properties
     * of the object schema.
     * 
     * @param $config Closure
     * 
     * @return void
     */
    public function do($config)
    {
        $config($this);
    }
}
