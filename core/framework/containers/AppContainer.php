<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 22.12.2015
 * Time: 16:38
 */

namespace containers;


class AppContainer {

    private static $apps = [];

    public static function registerApplication(array $appConfigData) {
        array_push(self::$apps, $appConfigData);
    }


}