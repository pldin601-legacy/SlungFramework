<?php

use utils\Config;

/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = null) {
    $value = getenv($key);
    if ($value === false) {
        return value($default);
    }
    return normalize($value);
}

/**
 * @param mixed $value
 * @param $args
 * @return mixed
 */
function value($value) {
    return $value instanceof Closure ? $value() : $value;
}

/**
 * @param string $value
 * @return mixed
 */
function normalize($value) {
    switch (strtolower($value)) {
        case "true":
            return true;
        case "false":
            return false;
        case "empty":
            return "";
        case "null":
            return null;
    }
    return unquote($value);
}

/**
 * @param string $text
 * @return string
 */
function unquote($text) {
    $trimmed = trim($text);
    if (substr($trimmed, 0, 1) === '"' && substr($trimmed, -1, 1) === '"') {
        return substr($trimmed, 1, strlen($trimmed) - 2);
    }
    return $trimmed;
}

/**
 * @param $key
 * @param mixed $default
 * @return mixed
 */
function setting($key, $default = null) {

    return Config::fast($key, $default);

}

function compile($pattern, $arguments, $returns) {
    return Functional\Compiler::compile2($pattern, $arguments, $returns);
}