<?php

require_once "../core/framework/init.php";

$value = new Option\Some(new Hello);

$value->map("$.foo()")->then("echo $");


class Hello {
    function foo() {
        return "Some string.";
    }
}