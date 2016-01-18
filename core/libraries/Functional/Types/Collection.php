<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.01.2016
 * Time: 12:13
 */

namespace Functional\Types;


use Functional\Compiler;

class Collection implements \ArrayAccess, \JsonSerializable, \Countable {
    private $container = array();
    public function __construct(array $initial = null) {
        if (!is_null($initial))
            $this->container = $initial;
    }

    public function map($callable) {
        return new self(array_map(Compiler::getCallableObject($callable), $this->container));
    }
    public function filter($callable) {
        return new self(array_values(array_filter($this->container, Compiler::getCallableObject($callable))));
    }
    public function reduce($callable, $initial = null) {
        return array_reduce($this->container, Compiler::getCallableObject($callable), $initial);
    }
    public function sort($callable) {
        $copy = $this->container;
        uasort($copy, Compiler::getCallableObject($callable));
        return new self($copy);
    }
    public function join($string) {
        return implode($string, $this->container);
    }

    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
    public function offsetGet($offset) {
        return $this->container[$offset];
    }
    public function offsetSet($offset, $value) {
        if (!isset($this[$offset])) {
            throw new \Exception("Item with offset {$offset} is not exists");
        }
        $this->container[$offset] = $value;
    }
    public function offsetUnset($offset) {
        if (!isset($this[$offset])) {
            throw new \Exception("Item with offset {$offset} is not exists");
        }
        unset($this->container[$offset]);
    }

    public function __toString() {
        ob_start();
        print_r($this->container);
        return ob_get_clean();
    }
    function jsonSerialize() {
        return json_encode($this->container, JSON_UNESCAPED_UNICODE);
    }
    function count() {
        return count($this->container);
    }

}