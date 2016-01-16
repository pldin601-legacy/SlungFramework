<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 22.12.2015
 * Time: 15:14
 */

namespace utils;


class Config {

    private static $confPath = "core/config";

    private static $confCache = [];

    private $config;

    public function __construct($config) {
        if (!isset(self::$confCache[$config])) {
            $filename = "../" . self::$confPath . "/" . $config . ".php";
            if (file_exists($filename)) {
                self::$confCache[$config] = require $filename;
            } else {
                self::$confCache[$config] = [];
            }
        }
        $this->config = $config;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null) {

        $keyPath = explode(".", $key);

        $data = self::$confCache[$this->config];

        while ($subKey = array_shift($keyPath)) {
            if (isset($data[$subKey])) {
                $data = &$data[$subKey];
            } else {
                return value($default);
            }
        }

        return $data;

    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public static function fast($key, $default = null) {

        $keyPath = explode('.', $key, 2);

        if (count($keyPath) != 2) {
            throw new \Exception('incorrect setting $key');
        }

        $config = new self($keyPath[0]);

        return $config->get($keyPath[1], $default);

    }

}