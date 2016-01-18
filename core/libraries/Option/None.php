<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 22.12.2015
 * Time: 17:00
 */

namespace Option;


use Functional\Compiler;

class None extends Option {

    private static $_instance = null;

    public static function getInstance() {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return false;
    }

    /**
     * @param string $offset
     * @return $this
     */
    public function offsetGet($offset) {
        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty() {
        return true;
    }

    /**
     * @return mixed
     */
    public function get() {
        throw new self::$exceptionClass("empty option");
    }

    /**
     * @param $value
     * @return bool
     */
    public function equals($value) {
        return $value instanceof None;
    }

    /**
     * @param $else
     * @return mixed
     */
    public function getOrElse($else) {
        return $else;
    }

    /**
     * @return mixed
     */
    public function getOrFalse() {
        return false;
    }

    /**
     * @return mixed
     */
    public function getOrZero() {
        return 0;
    }

    /**
     * @return mixed
     */
    public function getOrNull() {
        return null;
    }

    /**
     * @return mixed
     */
    public function getOrEmpty() {
        return "";
    }

    /**
     * @param $callable
     * @return mixed
     */
    public function getOrCall($callable) {
        return call_user_func(Compiler::getCallableObject($callable, 0));
    }

    /**
     * @param Option $alternative
     * @return Option
     */
    public function orElse(Option $alternative) {
        return $alternative;
    }

    /**
     * @param mixed $exception
     * @param array $args
     * @return mixed
     * @throws mixed
     */
    public function getOrThrow($exception, array $args = null) {
        $this->orThrow($exception, $args);
    }

    /**
     * @param $callable
     * @return $this
     */
    public function map($callable) {
        return $this;
    }

    /**
     * @param $callable
     * @return $this
     */
    public function flatMap($callable) {
        return $this;
    }

    /**
     * @param $predicate
     * @return $this
     */
    public function filter($predicate) {
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function select($value) {
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function reject($value) {
        return $this;
    }

    /**
     * @return $this
     */
    public function toInt() {
        return $this;
    }

    /**
     * @param callable $exception
     * @param array $args
     * @return $this
     * @throws mixed
     */
    public function orThrow($exception, array $args = null) {
        throw ($exception instanceof \Exception) ? $exception : new $exception(...$args);
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function then($callable) {
        return $this;
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function otherwise($callable) {
        call_user_func(Compiler::getCallableObject($callable, 0));
        return $this;
    }

    /**
     * @param $other
     * @param callable $callable
     * @return $this
     */
    public function reduce(Option $other, $callable) {
        return $this;
    }

    /**
     * @return string
     */
    public function __toString() {
        return "None";
    }
}