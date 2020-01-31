<?php

namespace Dry\Schema;
use Dry\Schema\Utility;
use Dry\DryStruct;

class ObjectProperty extends DryStruct
{
  public function do($config)
  {
    $config($this);
  }
}