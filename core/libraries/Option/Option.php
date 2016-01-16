<?php

namespace Option;

/**
 * Class Option
 * @package Tools\Optional
 */
abstract class Option implements \ArrayAccess {

    use OptionMixin;

    /**
     * @var string $exception
     */
    protected static $exceptionClass = \Exception::class;

    /**
     * @return bool
     */
    public abstract function isEmpty();

    /**
     * @return bool
     */
    public function nonEmpty() {

        return ! $this->isEmpty();

    }

    /**
     * @return mixed
     */
    public abstract function get();

    /**
     * @param mixed $value
     * @return bool
     */
    public abstract function equals($value);

    /**
     * @param mixed $else
     * @return mixed
     */
    public abstract function getOrElse($else);

    /**
     * @return mixed
     */
    public abstract function getOrFalse();

    /**
     * @return mixed
     */
    public abstract function getOrZero();

    /**
     * @return mixed
     */
    public abstract function getOrNull();

    /**
     * @return mixed
     */
    public abstract function getOrEmpty();

    /**
     * @param callable $callable
     * @return mixed
     */
    public abstract function getOrCall($callable);

    /**
     * @param Option $alternative
     * @return Option
     */
    public abstract function orElse(Option $alternative);

    /**
     * @param mixed $exception
     * @param array|null $args[]
     */
    public abstract function getOrThrow($exception, array $args = null);

    /**
     * @param callable $callable
     * @return $this
     */
    public abstract function map($callable);

    /**
     * @param callable $callable
     * @return $this
     */
    public abstract function flatMap($callable);

    /**
     * @param callable $predicate
     * @return $this
     */
    public abstract function filter($predicate);

    /**
     * @param mixed $value
     * @return $this
     */
    public abstract function select($value);

    /**
     * @param mixed $value
     * @return $this
     */
    public abstract function reject($value);

    /**
     * @return $this
     */
    public abstract function toInt();

    /**
     * @param callable $callable
     * @param array $args
     * @return $this
     */
    public abstract function orThrow($callable, array $args = []);

    /**
     * @param callable $callable
     * @return $this
     */
    public abstract function then($callable);

    /**
     * @param callable $callable
     * @return $this
     */
    public abstract function otherwise($callable);

    /**
     * @param Option $other
     * @param callable $callable
     * @return $this
     */
    public abstract function reduce(Option $other, $callable);

    public function offsetSet($offset, $value) {
        throw new \Exception("Operation unavailable");
    }

    public function offsetUnset($offset) {
        throw new \Exception("Operation unavailable");
    }

}


