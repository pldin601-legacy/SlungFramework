<?php

require_once "../core/framework/init.php";

$value = new Option\Some(100);

$value->map("_ / 2")->map("4 ^ _")->filter("_ > 10")->then("echo _");
