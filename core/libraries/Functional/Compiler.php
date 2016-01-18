<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 22.12.2015
 * Time: 17:35
 */

namespace Functional;


class Compiler {

    const VARIABLE_PATTERN = '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*';

    private static $phCache = [];

    public static function compile($pattern, $withReturn = true) {

        $hash = self::getPatternHash($pattern.":".($withReturn?1:0));

        if (!isset(self::$phCache[$hash])) {

            $lambdaArgs = [];

            if (strpos($pattern, '$', 0) === false) {
                throw new \Exception('No placeholder in pattern');
            }
            $patternParts = explode('$', $pattern);
            $compiledPattern = array_shift($patternParts);
            foreach ($patternParts as $patternPart) {
                $argName = '$a' . count($lambdaArgs);
                $compiledPattern .= $argName;
                $lambdaArgs[] = $argName;
                $compiledPattern .= $patternPart;
            }

            $compiledPattern = preg_replace('~(\$'.self::VARIABLE_PATTERN.')(\.)('.self::VARIABLE_PATTERN.')~i',
                '$1->$3', $compiledPattern);

            $functionBody = 'return function('.implode(',', $lambdaArgs).'){'.($withReturn?'return ':'').$compiledPattern.';};';

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