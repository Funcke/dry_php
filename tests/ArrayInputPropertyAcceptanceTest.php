<?php
require_once('./tests/schemas/ExampleSchema.php');

use Dry\Exception\InvalidSchemaException;

it('accepts a valid schema', function() {
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
        $result = (new ExampleSchema())->validate($data_array); 
    }catch (InvalidSchemaException $err) 
    {
        $thrown = true;
    }
    expect($thrown)->not->toBe(true);
    expect($result)->toBeEmpty();
});

it('accepts optional fields to be misssing', function() {
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
        $result = (new ExampleSchema())->validate($data_array); 
    }catch (InvalidSchemaException $err) {
        $thrown = true;
    }
    expect($thrown)->not->toBe(true);
    expect($result)->toBeEmpty();
});

it('recognises additional fields', function() {
    $data_array = ["name" => "Josef", "age" => 7, "email" => "hello@world", "book" => (object)["title" => "example"], "buyers" =>[
        (object)[
            "name" => "Richard"
        ],
        (object)[
            "name" => "Lorenz"
        ]
    ]
    ];
    $result = (new ExampleSchema())->validate($data_array);
    expect($result)->not->toBeEmpty();
    expect($result)->toEqual([
        "additional" => [
            "email"
        ]
    ]);
});

it('requires required fields to be present', function() {
    $data_array = ["age" => 7, "book" => (object) ["title" => "example"], "buyers" =>[
        (object)[
            "name" => "Richard"
        ],
        (object)[
         "name" => "Lorenz"
        ]
    ]
    ];
    $result = (new ExampleSchema())->validate($data_array); 
    expect($result)->not->toBeEmpty();
    expect($result)->toEqual([
        "name" =>["missing"]
    ]);
});

it('displays errors in array properties', function() {
    $data_array = ["age" => 7, "book" => (object) ["title" => "example"], "buyers" =>[
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
    expect($result)->toEqual([
        "name" => ["missing"],
        "buyers" => [
            0 =>[ 
                "name" => ["missing"],
                "additional" => ["address"]
            ]
        ]
    ]);
});

it('displays wrong value in array field', function() {
    $data_array = ["age" => 7, "book" => (object) ["title" => "example"], "buyers" =>[
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
    expect($result)->toEqual([
        "name" => ["missing"],
        "buyers" => [
            0 => [
                "name" => ["type"]
            ]
        ]
    ]);
});

it('reports errors in object property', function() {
    $data_array = ["name" => "richard", "age" => 7, "book" => (object) ["title" => 0], "buyers" =>[
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
    expect($result)->toEqual([
        "book" => [
            "title" => ["type"]
        ]
    ]);
});
