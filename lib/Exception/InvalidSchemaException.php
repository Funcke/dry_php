<?php

namespace Dry\Exception;

/**
 * Class InvalidSchemaException
 * @package Dry\Exception
 */
class InvalidSchemaException extends \Exception {
    /**
     * @var string
     * Name of the malicious property, which has caused the exception.
     */
    public $Property;

    /**
     * InvalidSchemaException constructor.
     * @param $property_name - Name of the faulty property
     * @param string $message
     */
    public function __construct(string $property_name, $message = "") {
        parent::__construct(empty($message) ? "Property not valid: ".$property_name : $message);
        $this->Property = $property_name;
    }
}