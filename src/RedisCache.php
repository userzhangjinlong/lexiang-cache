<?php
/**
 * Created by PhpStorm.
 * User: zjl
 * Date: 20-2-5
 * Time: 下午5:47
 */
namespace LexiangCache;

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

        $temp =  static::$instance;

        return $temp->connectRedis();
    }

    private function __construct()
    {
    }

    /**
     * @return Client
     */
    private function connectRedis()
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
            'port'  =>  ENV('REDIS_PORT') ?: '6379',
            'password' => ENV('REDIS_PASSWORD') ?: NULL
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