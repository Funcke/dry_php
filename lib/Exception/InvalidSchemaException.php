<?php

/**
 * InvalidSchemaException
 * 
 * PHP Version 7.3
 * 
 * Exception to throw when violations are present in provided input
 * 
 * @category Class
 * @package  Dry\Exception
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */
namespace Dry\Exception;

/**
 * Class InvalidSchemaException
 * 
 * @category Class
 * @package  Dry\Exception
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */
class InvalidSchemaException extends \Exception
{
    /**
     * Name of the malicious property, which has caused the exception.
     * 
     * @var string
     */
    public $Property;

    /**
     * InvalidSchemaException constructor.
     *
     * @param $property_name string - Name of the faulty property
     * @param $message       string
     */
    public function __construct(string $property_name, $message = "")
    {
        parent::__construct(
            empty($message) ? "Property not valid: ".$property_name : $message
        );
        $this->Property = $property_name;
    }
}
