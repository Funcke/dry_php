<?php
declare(strict_types=1);
require_once('./test/schemas/ExampleSchema.php');

use PHPUnit\Framework\TestCase;
use Dry\Exception\InvalidSchemaException;
final class ArrayInputPropertyAcceptanceTest extends TestCase
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
    }

    public function testAcceptsOptionalFieldsToBeMissing(): void
    {
      $thrown = false;
      try {
        $data_array = ["name" => "Josef"];
        (new ExampleSchema())->validate($data_array); 
      }catch (InvalidSchemaException $err) 
      {
        $thrown = true;
      }
      $this->assertEquals(false, $thrown);
    }

    public function testRecognisesAdditionalFields(): void
    {
      $this->expectException(InvalidSchemaException::class);
      $data_array = ["name" => "Josef", "age" => 7, "email" => "hello@world"];
      (new ExampleSchema())->validate($data_array); 
    }

    public function testRequiresRequiredFieldsTobePresent(): void
    {
      $this->expectException(InvalidSchemaException::class);
      $data_array = ["age" => 7];
      (new ExampleSchema())->validate($data_array); 
    }
}
