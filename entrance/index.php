<?php

use Functional\Types\ImmutableCollection;

require_once "../core/framework/init.php";

$collection = new ImmutableCollection([
    [
        "id" => 0,
        "name" => "Bob",
        "age" => 36
    ],
    [
        "id" => 1,
        "name" => "Sam",
        "age" => 17
    ],
    [
        "id" => 2,
        "name" => "John",
        "age" => 21
    ]
]);

header("Content-Type: text/plain");

echo $collection                 // Original collection of persons
    ->map('(object) $1')         // Cast all persons to objects
    ->filter('$1->age >= 18')    // Filter only adults
    ->sort('$1->age > $2->age')  // Sort persons by age
    ->map('$->name')             // Get person names
    ->join(', ');                // Get list of names joined by comma delimiter
