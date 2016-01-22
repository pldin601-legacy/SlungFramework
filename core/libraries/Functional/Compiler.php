<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 22.12.2015
 * Time: 17:35
 */

namespace Functional;


class Compiler {

    const FUNCTION_VARIABLES_COUNT      = 1;
    const BI_FUNCTION_VARIABLES_COUNT   = 2;
    const CONSUMER_VARIABLES_COUNT      = 1;
    const BI_CONSUMER_VARIABLES_COUNT   = 2;
    const PRODUCER_VARIABLES_COUNT      = 0;

    const VARIABLE_PATTERN = '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*';
    const PLACEHOLDER_TEMPLATE          = '~(\$)(\d+)~';

    private static $phCache = [];

    /**
     * @param string $pattern Pattern to be converted into Closure
     * @param int $arguments Number of arguments will be passed to Closure
     * @param boolean $returns Is Closure returns result
     * @return \Closure
     */
    public static function compile($pattern, $arguments, $returns) {
        $hash = self::getPatternHash([$pattern, $returns]);
        if (empty(self::$phCache[$hash])) {
            $build  = 'return function(';
            $build .= self::generateVariablesList($arguments);
            $build .= '){';
            if ($returns) {
                $build .= 'return ';
            }
            $build .= preg_replace('~(\$)(\d+)~', '$1a$2', $pattern);
            $build .= ';};';
            self::$phCache[$hash] = eval($build);
        }
        return self::$phCache[$hash];
    }

    public static function compileFunction($pattern) {
        $code = 'return function(' . self::generateVariablesList(1) . '){return ' . preg_replace(self::PLACEHOLDER_TEMPLATE, '$1a$2', $pattern) . ';};';
        return eval($code);
    }

    public static function compileBiFunction($pattern) {
        $code = 'return function(' . self::generateVariablesList(2) . '){return ' . preg_replace(self::PLACEHOLDER_TEMPLATE, '$1a$2', $pattern) . ';};';
        return eval($code);
    }

    public static function compileConsumer($pattern) {
        $code = 'return function(' . self::generateVariablesList(1) . '){' . preg_replace(self::PLACEHOLDER_TEMPLATE, '$1a$2', $pattern) . ';};';
        return eval($code);
    }

    public static function compileBiConsumer($pattern) {
        $code = 'return function(' . self::generateVariablesList(2) . '){' . preg_replace(self::PLACEHOLDER_TEMPLATE, '$1a$2', $pattern) . ';};';
        return eval($code);
    }

    public static function compileProducer($pattern) {
        $code = 'return function(){return ' . preg_replace(self::PLACEHOLDER_TEMPLATE, '$1a$2', $pattern) . ';};';
        return eval($code);
    }

    /**
     * @param int $count
     * @return string
     */
    public static function generateVariablesList($count) {
        $variables = [];
        for ($i = 0; $i < $count; $i ++) {
            $variables[] = '$a' . $i;
        }
        return implode(',', $variables);
    }

    public static function getCallableObject($function, $arguments, $returns = true) {
        switch (gettype($function)) {
            case 'string':
                return function_exists($function) ? $function : self::compile($function, $arguments, $returns);
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
        return md5(serialize($pattern));
    }

}