<?php
/**
 * Created by PhpStorm.
 * User: zjl
 * Date: 20-2-6
 * Time: 下午2:59
 */

namespace LexiangCache;



use Predis\Pipeline\Pipeline;


class RedisHelper
{
    /**
     * hash 类型的缓存
     * @param $key
     * @param array $hash
     * @return mixed
     */
    public function setHash($key, array $hash)
    {
        $key = self::_buildKey($key);
        $params = [];
        foreach ($hash as $hashKey => $hashValue) {
            $params[$hashKey] = is_array($hashValue) ? json_encode($hashValue) : $hashValue;
        }

        return self::_redis()->hmset($key, $params);
    }


    /**
     * 获得一个或多个hash数据
     * @param $key
     * @param array $fields
     * @return array|null
     */
    public function getValueByHash($key, array $fields)
    {
        $key = self::_buildKey($key);

        if (!is_array($fields)) {
            return null;
        }

        $data = [];
        $result = [];

        if (is_array($fields)) {
            $data = self::_redis()->hMget($key, array_values($fields));
        } else {
            $result = self::_redis()->connect->hGet($key, $fields);
        }

        if ($data) {
            foreach ($data as $k => $v) {
                if (is_object($v)) {
                    $result[$k] = json_decode($v, true);
                } else {
                    $result[$k] = $v;
                }
            }
        }
        return $result;
    }


    /**
     * 获得所有hash中所有数据
     * @param $key
     * @return array
     */
    public function getHashAll($key)
    {
        $key = self::_buildKey($key);
        $cacheData = self::_redis()->hgetall($key);

        if (!empty($cacheData)) {
            $datum = [];
            foreach ($cacheData as $key => $jsonStr) {
                $datum[$key] = is_object(json_decode($jsonStr)) ? json_decode($jsonStr, true) : $jsonStr;
            }
            return $datum;
        }
        return $cacheData;
    }

    /**
     * 移除hash中一个或多个字段的数据
     * @param $key
     * @param array $fields
     * @return int
     */
    public function removeHash($key, array $fields)
    {
        if (empty($fields)) {
            return 0;
        }

        $key = self::_buildKey($key);
        $pipeline = self::_redis()->pipeline();

        foreach ($fields as $v){
            $res = $pipeline->hdel($key,$v);
        }

        return $res->exec();
    }

    /**
     * 删除 redis 表名
     * @param $tableName 表名
     * @return mixed
     */
    public function hDel($tableName)
    {
        return self::_redis()->hdel($tableName);
    }

    /**
     * Notes: 删除指定库
     * @param $databases
     * @return bool
     * @throws \Lock\LockException
     */
    public function delFlushDB($databases)
    {
        self::_redis()->select($databases);
        self::_redis()->flushDB();
        return true;
    }

    /**
     * @return mixed
     */
    private static function _redis()
    {
        return RedisCache::getInstance();
    }


    /**
     * @param $key
     * @return string
     */
    private static function _buildKey($key)
    {
        return 'cache_' . $key;
    }
}
