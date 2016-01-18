<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 22.12.2015
 * Time: 17:14
 */

namespace Option;


use Functional\Compiler;

class Some extends Option {

    private $value;

    public function __construct($value) {
        $this->value = $value;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return true;
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return $this->get();
    }

    /**
     * @return bool
     */
    public function isEmpty() {
        return false;
    }

    /**
     * @return mixed
     */
    public function get() {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function equals($value) {
        return  $value instanceof None ? false :
               ($value instanceof Some ? ($value->get() === $this->get()) : ($value === $this->get()));
    }

    /**
     * @param mixed $else
     * @return mixed
     */
    public function getOrElse($else) {
        return $this->get();
    }

    /**
     * @return mixed
     */
    public function getOrFalse() {
        return $this->get();
    }

    /**
     * @return mixed
     */
    public function getOrZero() {
        return $this->get();
    }

    /**
     * @return mixed
     */
    public function getOrNull() {
        return $this->get();
    }

    /**
     * @return mixed
     */
    public function getOrEmpty() {
        return $this->get();
    }

    /**
     * @param callable $callable
     * @return mixed
     */
    public function getOrCall($callable) {
        return $this->get();
    }

    /**
     * @param Option $alternative
     * @return Option
     */
    public function orElse(Option $alternative) {
        return $this;
    }

    /**
     * @param mixed $exception
     * @param array|null $args []
     * @return mixed
     */
    public function getOrThrow($exception, array $args = null) {
        return $this->get();
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function map($callable) {
        return new Some(call_user_func(Compiler::getCallableObject($callable, 1), $this->get()));
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function flatMap($callable) {
        return call_user_func(Compiler::getCallableObject($callable, 1), $this->get());
    }

    /**
     * @param callable $predicate
     * @return $this
     */
    public function filter($predicate) {
        return call_user_func(Compiler::getCallableObject($predicate, 1), $this->get()) ? $this : None::getInstance();
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function select($value) {
        return $this->get() === $value ? $this : None::getInstance();
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function reject($value) {
        return $this->get() === $value ? None::getInstance() : $this;
    }

    /**
     * @return $this
     */
    public function toInt() {
        return new self(intval($this->get()));
    }

    /**
     * @param callable $callable
     * @param array $args
     * @return $this
     */
    public function orThrow($callable, array $args = []) {
        return $this;
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function then($callable) {
        call_user_func(Compiler::getCallableObject($callable, 1, false), $this->get());
        return $this;
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function otherwise($callable) {
        return $this;
    }

    /**
     * @param Option $other
     * @param callable $callable
     * @return $this
     */
    public function reduce(Option $other, $callable) {
        return $callable($this, $other);
    }

    /**
     * @return string
     */
    public function __toString() {
        return "Some(" . $this->get() . ")";
    }
}