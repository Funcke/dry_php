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
        $data_array = ["name" => "Josef", "age" => 7, "book" => (object)["title" => "example"], "buyers" =>[
                (object)[
                    "name" => "Richard"
                ],
                (object)[
                    "name" => "Lorenz"
                ]
            ]
        ];
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
        $data_array = ["name" => "Josef", "book" => (object)["title" => "example"], "buyers" =>[
            (object)[
                "name" => "Richard"
            ],
            (object)[
                "name" => "Lorenz"
            ]
        ]
        ];
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
      $data_array = ["name" => "Josef", "age" => 7, "email" => "hello@world", "book" => (object)["title" => "example"], "buyers" =>[
          (object)[
              "name" => "Richard"
          ],
          (object)[
              "name" => "Lorenz"
          ]
      ]
      ];
      (new ExampleSchema())->validate($data_array); 
    }

    public function testRequiresRequiredFieldsTobePresent(): void
    {
      $this->expectException(InvalidSchemaException::class);
      $data_array = ["age" => 7, "book" => (object) ["title" => "example"], "buyers" =>[
          (object)[
              "name" => "Richard"
          ],
          (object)[
              "name" => "Lorenz"
          ]
      ]
      ];
      (new ExampleSchema())->validate($data_array); 
    }

    public function testWithErrorInArray(): void
    {
        $this->expectException(InvalidSchemaException::class);
        $data_array = ["age" => 7, "book" => (object) ["title" => "example"], "buyers" =>[
            (object)[
                "address" => "Richard"
            ],
            (object)[
                "name" => "Lorenz"
            ]
        ]
        ];
        (new ExampleSchema())->validate($data_array);
    }

    public function testWithErrorWrongValueInArray(): void
    {
        $this->expectException(InvalidSchemaException::class);
        $data_array = ["age" => 7, "book" => (object) ["title" => "example"], "buyers" =>[
            (object)[
                "name" => 2
            ],
            (object)[
                "name" => "Lorenz"
            ]
        ]
        ];
        (new ExampleSchema())->validate($data_array);
    }
}
