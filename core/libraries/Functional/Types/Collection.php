<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.01.2016
 * Time: 14:29
 */

namespace Functional\Types;


interface Collection extends \ArrayAccess, \Countable, \JsonSerializable {
    function map($callable);
    function filter($callable);
    function reduce($callable, $initial = null);
    function sort($callable);
    function join($string);

    function push($element);
    function pop();
    function shift();
    function unShift($element);
}
