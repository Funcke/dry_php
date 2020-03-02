<?php

namespace Dry\Schema;
use Dry\Schema\Utility;
use Dry\Schema\ObjectProperty;

class ArrayProperty
{
    private $element;

    public function __construct()
    {
        ;
    }

    public function type($type)
    {
        if ($type === 'object') {
            $this->element = new ObjectProperty();
        } else if ($type === 'array') {
            $this->element = new ArrayProperty();
        } else {
            $this->element = new Property();
        }

        return $this->element;
    }

    public function each($function)
    {
        $function($this);
    }

    public function validate($value)
    {
        foreach ($value as $element) {
            $this->element->validate($element);
        }
    }
}