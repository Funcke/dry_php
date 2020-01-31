# Dry validation for php [![Build Status](https://travis-ci.org/Funcke/dry_php.svg?branch=master)](https://travis-ci.org/Funcke/dry_php)
A typical PHP app is constantly dealing with a shitload of if-clauses to determine, wether or not an entity is compliant with the constraint the developers had in mind, when creating their software.

Dry offers a simple way to eleminate overhead validation clauses and centers constraints for any type of entity in one file. Just call validate on an instance of this class and it will validate the parameter you provide.

## Wether Array or Object Dry::PHP doesn't care
You may validate an entity multiple times:
* when passed to an endpoint
* before storing in the database
* after deserializing from a file or similiar

With Dry::PHP you just define one single file of constraints and call it on the data.
Dry::PHP supports associative arrays in form of [property => value] and standard PHP Objects.
The Object itself will be casted to an array during the validation process and then checked.

*be careful: private properties or properties inherited from the parent class will also be included in the checking process!*

## Example
```PHP
# ExampleSchema.php
<?php
use Dry\DryStruct;

class ExampleSchema extends DryStruct 
{
  public function __construct() {
    parent::__construct();
    self::required('name')->filled('string');
    self::optional('age')->filled('integer')->min(6);
  }
}
```
```PHP
# index.php
<?php
# validate expected schema
(new ExampleSchema())->validate(['name' => 'Richard', 'age' => 7]);
# validate faulty schema => method call will throw Exception
(new ExampleSchema())->validate(['name' => 'Richard', 'age' => 4]);
```
## supported constraints
* filled:
  datatype of the property, depending on the expected datatype, further evaluation will be executed
* min:
  Minimum value for a number property
* max:
  Maximum value for a number property
* minLength:
  Minimum length for a string property
* maxLength:
  Maximum length for a string property
* minSize:
  Minimum size for an array property
* maxSize:
  Maximum size for an array property
