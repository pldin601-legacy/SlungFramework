<?php

require_once "../core/framework/init.php";

$collection = [
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
];

uasort($collection, compile("$['age'] - $['age']"));

header("Content-Type: text/plain");
print_r($collection);