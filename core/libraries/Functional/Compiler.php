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

    public static function compile($pattern, $withReturn = false) {

        $hash = self::getPatternHash($pattern.":".($withReturn?1:0));

        if (!isset(self::$phCache[$hash])) {

            $args = [];

            // todo: optimize without using regular expressions
            $body = preg_replace_callback('~_~', function () use (&$args) {
                $argName = '$a' . count($args);
                $args[] = $argName;
                return $argName;
            }, $pattern);

            $functionBody = 'return function('.implode(',', $args).'){'.($withReturn?'return ':'').$body.';};';

//            $body = preg_replace_callback('~\$[a-z0-9_]+(\.)~i', function () { return '=>'; }, $body);
            $body = preg_replace_callback('~[a-z]+(\.)~i', function () { return '::'; }, $body);

            self::$phCache[$hash] = eval($functionBody);

        }

        return self::$phCache[$hash];

    }

    public static function getCallableObject($function, $withReturn = true) {

        switch (gettype($function)) {
            case 'string':
                return function_exists($function) ? $function : self::compile($function, $withReturn);
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