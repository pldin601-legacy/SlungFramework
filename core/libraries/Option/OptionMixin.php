<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 22.12.2015
 * Time: 16:54
 */

namespace Option;


trait OptionMixin {
    /*---------------------------------------------------------------*/
    /*                    Static Factory Methods                      */
    /*---------------------------------------------------------------*/

    /**
     * @param $value
     * @return Option
     */
    public static function ofNullable($value) {
        return is_null($value) ? None::getInstance() : new Some($value);
    }

    /**
     * @param $value
     * @param $predicate
     * @return Option
     */
    public static function of($value, $predicate) {
        return $predicate($value) ? new Some($value) : None::getInstance();
    }

    /**
     * @param $value
     * @return Option
     */
    public static function ofEmpty($value) {

        if (is_null($value)) return None::getInstance();
        if (is_array($value) && count($value) == 0) return None::getInstance();
        if (is_string($value) && strlen($value) == 0) return None::getInstance();

        return new Some($value);

    }

    /**
     * @param $value
     * @return Option
     */
    public static function ofNumber($value) {
        return is_numeric($value) ? new Some($value) : None::getInstance();
    }

    /**
     * @param $value
     * @return Option
     */
    public static function ofArray($value) {
        return is_array($value) ? new Some($value) : None::getInstance();
    }

    /**
     * @param $value
     * @return Option
     */
    public static function ofDeceptive($value) {
        return $value === false ? None::getInstance() : new Some($value);
    }

    /**
     * @param $filePath
     * @return Option
     */
    public static function ofFile($filePath) {
        return file_exists($filePath) ? new Some($filePath) : None::getInstance();
    }
}