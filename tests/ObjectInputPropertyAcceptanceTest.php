<?php
declare(strict_types=1);
require_once './tests/schemas/ExampleSchema.php';

use PHPUnit\Framework\TestCase;
use Dry\Exception\InvalidSchemaException;

it(
    'accepts valid schemas', function () {
        $thrown = false;
        try {
            $data_object = (object) ["name" => "John", "age" => 23, "book" => (object)["title" => "example"], "buyers" =>[
              (object)[
              "name" => "Richard"
              ],
              (object)[
              "name" => "Lorenz"
              ]
            ]
            ];
            $result = (new ExampleSchema())->validate($data_object);
        }catch (InvalidSchemaException $err) 
        {
            $thrown = true;
        }
        expect($result)->toBeEmpty();
        expect($thrown)->not->toBe(true);
    }
);

it(
    'allows optional fields to be missing', function () {
        $thrown = false;
        try {
            $data_object = (object) ["name" => "John", "book" => (object)["title" => "example"], "buyers" =>[
            (object)[
                "name" => "Richard"
            ],
            (object)[
                "name" => "Lorenz"
            ]
            ]
            ];
            $result = (new ExampleSchema())->validate($data_object);
        }catch (InvalidSchemaException $err) {
            $thrown = true;
        }
        expect($thrown)->not->toBe(true);
        expect($result)->toBeEmpty($result);
    }
);

it(
    'recognises additional fields', function () {
        $data_object = (object) ["name" => "Josef", "age" => 7, "email" => "hello@world", "buyers" =>[
        (object)[
            "name" => "Richard"
        ],
        (object)[
            "name" => "Lorenz"
        ]
        ]
        ];
        $result = (new ExampleSchema())->validate($data_object);
        expect($result)->toBeArray();
        expect($result)->not->toBeEmpty();
        expect($result)->toEqual(
            [
            "additional" => ["email"],
            "book" => ["missing"]
            ]
        );
    }
);

it(
    'requires required fields to be present', function () {
        $data_object = (object) ["age" => 7, "buyers" =>[
        (object)[
            "name" => "Richard"
        ],
        (object)[
            "name" => "Lorenz"
        ]
        ]
        ];
        $result = (new ExampleSchema())->validate($data_object);
        expect($result)->not->toBeEmpty();
        expect($result)->toEqual(
            [
            "name" => ["missing"],
            "book" => ["missing"]
            ]
        );
    }
);

it(
    'recognizes errors in array properties', function () {
        $data_array = (object)["age" => 7, "book" => (object) ["title" => "example"], "buyers" =>[
        (object)[
            "address" => "Richard"
        ],
        (object)[
            "name" => "Lorenz"
        ]
        ]
        ];
        $result = (new ExampleSchema())->validate($data_array);
        expect($result)->not->toBeEmpty();
        expect($result)->toEqual(
            [
            "buyers" => [
            0 => [
                "name" => ["missing"],
                "additional" => ["address"]
            ]
            ],
            "name" => ["missing"]
            ]
        );
    }
);

it(
    'wrong values in array property', function () {
        $data_array = (object)["name" => "richard", "age" => 7, "book" => (object) ["title" => "example"], "buyers" =>[
        (object)[
            "name" => 2
        ],
        (object)[
            "name" => "Lorenz"
        ]
        ]
        ];
        $result = (new ExampleSchema())->validate($data_array);
        expect($result)->not->toBeEmpty();
        expect($result)->toEqual(
            [
            "buyers" => [
            0 => [
                "name" => ["type"]
            ]
            ]
            ]
        );
    }
);

it(
    'reports errors in object property', function () {
        $data_array = (object)["name" => "richard", "age" => 7, "book" => (object) ["title" => 0], "buyers" =>[
        (object)[
            "name" => "lewis"
        ],
        (object)[
            "name" => "Lorenz"
        ]
        ]
        ];
        $result = (new ExampleSchema())->validate($data_array);
        expect($result)->not->toBeEmpty();
        expect($result)->toEqual(
            [
            "book" => [
            "title" => ["type"]
            ]
            ]
        );
    }
);
