<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 19.01.2016
 * Time: 10:28
 */

namespace Functional\Types;


use Functional\Compiler;

class MutableCollection implements Collection {
    private $container = array();
    public function __construct(array $initial = null) {
        if (!is_null($initial))
            $this->container = $initial;
    }

    public function map($callable) {
        $this->container = array_map(Compiler::getCallableObject($callable, 1), $this->container);
        return $this;
    }
    public function filter($callable) {
        $this->container = array_values(array_filter($this->container, Compiler::getCallableObject($callable, 1)));
        return $this;
    }
    public function reduce($callable, $initial = null) {
        return array_reduce($this->container, Compiler::getCallableObject($callable, 2), $initial);
    }
    public function sort($callable) {
        uasort($this->container, Compiler::getCallableObject($callable, 2));
        return $this;
    }
    public function join($string) {
        return implode($string, $this->container);
    }

    function push($element) {
        $this->container[] = $element;
        return $this;
    }
    function pop() {
        return array_pop($this->container);
    }
    function shift() {
        return array_shift($this->container);
    }
    function unShift($element) {
        array_unshift($this->container, $element);
        return $this;
    }


    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
    public function offsetGet($offset) {
        return $this->container[$offset];
    }
    public function offsetSet($offset, $value) {
        $this->container[$offset] = $value;
        return $this;
    }
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
        return $this;
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