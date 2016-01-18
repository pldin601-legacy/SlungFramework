<?php

use Functional\Types\Collection;

require_once "../core/framework/init.php";

$collection = new Collection([
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

echo $collection                // Original collection of persons
    ->map("(object) $")         // Cast all persons to objects
    ->filter("$.age >= 18")     // Filter only adults
    ->sort("$.age > $.age")     // Sort persons by age
    ->map("$.name")             // Get person names
    ->join(", ");               // Get list of names joined by comma delimiter


