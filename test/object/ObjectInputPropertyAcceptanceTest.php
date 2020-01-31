<?php
declare(strict_types=1);
require_once('./test/schemas/ExampleSchema.php');

use PHPUnit\Framework\TestCase;
use Dry\Exception\InvalidSchemaException;
final class ObjectInputPropertyAcceptanceTest extends TestCase
{
    public function testAcceptsValidData(): void
    {
      $thrown = false;
      try {
        $data_object = (object) ["name" => "John", "age" => 23, "book" => (object)["title" => "example"]];
        (new ExampleSchema())->validate($data_object);
      }catch (InvalidSchemaException $err) 
      {
        $thrown = true;
      }
      $this->assertEquals(false, $thrown);
    }

    public function testAllowsOptionalFieldsToBeMissing(): void
    {
      $thrown = false;
      try {
        $data_object = (object) ["name" => "John", "book" => (object)["title" => "example"]];
        (new ExampleSchema())->validate($data_object);
      }catch (InvalidSchemaException $err) 
      {
        $thrown = true;
      }
      $this->assertEquals(false, $thrown);
    }

    public function testRecognisesAdditionalFields(): void
    {
      $this->expectException(InvalidSchemaException::class);
      $data_object = (object) ["name" => "Josef", "age" => 7, "email" => "hello@world"];
      (new ExampleSchema())->validate($data_object);
    }

    public function testRequiresRequiredFieldsToBePresent(): void
    {
      $this->expectException(InvalidSchemaException::class);
      $data_object = (object) ["age" => 7];
      (new ExampleSchema())->validate($data_object);
    }
}
