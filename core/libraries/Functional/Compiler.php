<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 22.12.2015
 * Time: 17:35
 */

namespace Functional;


class Compiler {

    private static $phCache = [];

    public static function compile($pattern) {

        $hash = self::getPatternHash($pattern);

        if (!isset(self::$phCache[$hash])) {

            $args = [];

            $body = preg_replace_callback('~_~', function () use (&$args) {
                $argName = '$a' . count($args);
                array_push($args, $argName);
                return $argName;
            }, $pattern);

            $functionBody = 'return function(' . implode(',', $args) . '){return ' . $body . ';};';

            self::$phCache[$hash] = eval($functionBody);

        }

        return self::$phCache[$hash];

    }

    public static function getCallableObject($function) {


        switch (gettype($function)) {
            case 'string':
                return function_exists($function) ? $function : self::compile($function);
            case 'array':
                if (count($function) == 2) {
                    if (class_exists($function[0]) || is_object($function[0])) {
                        return $function;
                    }
                }
                break;
            case 'object':
                return $function;
        }

        throw new \Exception('unsupported $callable');

    }

    private static function getPatternHash($pattern) {

        return md5($pattern);

    }

}