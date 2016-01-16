<?php

// Framework core loader
spl_autoload_register(function ($className) {
    $classFile =  "../core/framework/" . str_replace("\\", "/", $className) . ".php";
    if (file_exists($classFile)) {
        require_once $classFile;
    }
}, false);

// Framework libraries loader
spl_autoload_register(function ($className) {
    $classFile =  "../core/libraries/" . str_replace("\\", "/", $className) . ".php";
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});

set_exception_handler(function (Exception $exception) {
    echo $exception->getMessage();
    echo "<pre>";
    echo $exception->getTraceAsString();
    echo "</pre>";
});

set_error_handler(function ($code, $text, $file, $line, $context) {
    printf("%s in file %s at line %d", $text, $file, $line);
});

require_once "helpers.php";
require_once "apps.php";
