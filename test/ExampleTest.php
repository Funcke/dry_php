<?php
declare(strict_types=1);
require('./test/schemas/ExampleSchema.php');

use PHPUnit\Framework\TestCase;
use Dry\Exception\InvalidSchemaException;
final class ExampleTest extends TestCase
{
    public function testAcceptsValidData(): void
    {
      $thrown = false;
        try {
          $data_array = ["name" => "Josef", "age" => 7];
          (new ExampleSchema())->validate($data_array); 
        }catch (InvalidSchemaException $err) 
        {
          $thrown = true;
        }
        $this->assertEquals(false, $thrown);

        try {
          $data_object = (object) $data_array;
          (new ExampleSchema())->validate($data_array);
        }catch (InvalidSchemaException $err) 
        {
          $thrown = true;
        }
        $this->assertEquals(false, $thrown);
    }

    public function testRecognisesAdditionalFields(): void
    {
    }
}
