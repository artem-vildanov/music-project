<?php

namespace App\Utils;

use Predis\Client;

class RedisConnection
{
    private static ?Client $redisClient = null;

    public static function makeConnection(): Client
    {
        if (self::$redisClient === null) {
            self::$redisClient = new Client([
                'scheme' => env('REDIS_SCHEME'),
                'host'   => env('REDIS_HOST'),
                'port'   => env('REDIS_PORT')
            ]);
        }
        return self::$redisClient;
    }
}
