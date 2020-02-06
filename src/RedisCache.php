<?php
/**
 * Created by PhpStorm.
 * User: zjl
 * Date: 20-2-5
 * Time: 下午5:47
 */
namespace Lexiang;

use Predis\Client;

class RedisCache{
    private static $instance;
    private static $config;

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
        $config = self::getConfig();

        $redis = new Client($config);

        return $redis;

    }

    /**
     * @return array
     */
    private static function getConfig()
    {
        if (static::$config) return self::$config;

        self::$config = [
            'host'  =>  ENV('REDIS_HOST') ?: '127.0.0.1',
            'port'  =>  ENV('REDIS_PORT') ?: '6379'
        ];

        return self::$config;
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