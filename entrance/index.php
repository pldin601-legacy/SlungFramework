<?php

use Functional\Types\MutableCollection as Collection;

require_once "../core/framework/init.php";

$collection = new Collection(range(1, 10));

echo $collection->filter("$1 % 2 == 0")->reduce("$1 + $2", 0);
