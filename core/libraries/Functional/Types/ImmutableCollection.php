<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.01.2016
 * Time: 12:13
 */

namespace Functional\Types;


use Functional\Compiler;

class ImmutableCollection implements Collection {
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

    function push($element) {
        $copy = $this->container;
        $copy[] = $element;
        return new self($copy);
    }
    function pop() {
        $count = count($this);
        if ($count == 0) {
            return null;
        }
        return $this->container[$count - 1];
    }
    function shift() {
        $count = count($this);
        if ($count == 0) {
            return null;
        }
        return $this->container[0];
    }
    function unShift($element) {
        $copy = $this->container;
        array_unshift($copy, $element);
        return new self($copy);
    }


    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
    public function offsetGet($offset) {
        return $this->container[$offset];
    }
    public function offsetSet($offset, $value) {
        throw new \Exception("Immutable collection could not be changed this way");
    }
    public function offsetUnset($offset) {
        throw new \Exception("Immutable collection could not be changed this way");
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