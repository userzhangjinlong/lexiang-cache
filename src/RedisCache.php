<?php
/**
 * Created by PhpStorm.
 * User: zjl
 * Date: 20-2-5
 * Time: 下午5:47
 */
namespace Lexiang;

class RedisCache{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance instanceof self)
        {
            static::$instance = new self();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $redis = new Client();
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

}