<?php

/**
 * Property
 * 
 * PHP Version 7.3
 * 
 * Function Utilities for evaluating predicates.
 * 
 * @category Class
 * @package  Dry\Schema
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */

namespace Dry\Schema;

use Dry\Exception\InvalidSchemaException;

/**
 * Trait Utility
 *
 * This trait contains utility methods used to centralize the validation 
 * work of the DryStruct.
 * 
 * @category Class
 * @package  Dry\Schema
 * @author   Jonas Funcke <jonas@funcke.work>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/Funcke/dry_php/blob/master/lib/DryStruct.php
 */
trait Utility
{
    /**
     * Methods provides an array of closures associated with the validation work of
     * a constraint. The validation methods can be addressed by the name of the 
     * constraint they help assuring.
     *
     * @return array - array with closures
     */
    public static function methods()
    {
        return [
        "type" => function ($constraint, $value) {
            if (gettype($value) !== $constraint) {
                throw new InvalidSchemaException(
                    $value,
                    "Invalid type ". gettype($value) 
                    . "! " . $constraint . " expected."
                );
            }
        },
        "max" => function ($constraint, $value) {
            if ($value > $constraint) {
                throw new InvalidSchemaException($value); 
            } 
        },
        "min" => function ($constraint, $value) {
            if ($value < $constraint) {
                throw new InvalidSchemaException($value); 
            } 
        },
        "minLength" => function ($constraint, $value) {
            if (strlen($value) < $constraint) {
                throw new InvalidSchemaException($value); 
            } 
        },
        "maxLength" => function ($constraint, $value) {
            if (strlen($value) > $constraint) {
                throw new InvalidSchemaException($value); 
            } 
        },
        "format" => function ($constraint, $value) {
            if (!preg_match($constraint, $value)) {
                throw new InvalidSchemaException($value); 
            } 
        },
        "minSize" => function ($constraint, $value) {
            if (count($value) < $constraint) {
                throw new InvalidSchemaException($value); 
            } 
        },
        "maxSize" => function ($constraint, $value) {
            if (count($value) > $constraint) {
                throw new InvalidSchemaException($value); 
            } 
        },
        "notEmpty" => function ($constraint, $value) {
            if (empty($value)) {
                throw new InvalidSchemaException($value); 
            } 
        },
        "notNull" => function ($constraint, $value) {
            if ($value === null) { 
                throw new InvalidSchemaException(''); 
            } 
        }
        ];
    }
}
