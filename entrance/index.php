<?php

require_once "../core/framework/init.php";

$value = new Option\Some(new Hello);

$value->map("World::call($)")->then("echo $");


class Hello {
    function foo() {
        return "Some string.";
    }
}

class World {
    static function call(Hello $hello) {
        return $hello->foo();
    }
}