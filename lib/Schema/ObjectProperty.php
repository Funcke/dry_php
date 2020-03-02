<?php

namespace Dry\Schema;
use Dry\Schema\Utility;
use Dry\DryStruct;

/**
 * Class ObjectProperty
 * @package Dry\Schema
 */
class ObjectProperty extends DryStruct
{
    public function __construct() {
        parent::__construct();
    }
    /**
     * @param $config
     */
      public function do($config)
      {
          $config($this);
      }
}