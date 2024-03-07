<?php

namespace App\Services;

use App\Exceptions\RedisException;
use App\Models\Album;
use App\Utils\RedisConnection;
use Exception;
use Predis\Client;
use Predis\PredisException;

class CacheStorageService
{
    private Client $redis;

    public function __construct()
    {
        $this->redis = RedisConnection::makeConnection();
    }

    public function saveToCache(string $objectId, string $serializedObject): void
    {
        $EXPIRE_RESOLUTION = "EX";
        $TTL_IN_SEC = 60;
        $this->redis->set($objectId, $serializedObject, $EXPIRE_RESOLUTION, $TTL_IN_SEC);
    }

    public function getFromCache(string $objectId): string
    {
        try {
            $objectSerialized = $this->redis->get($objectId);
        } catch (PredisException $exception) {
            dd($exception);
        }

        return $objectSerialized;
    }

    public function deleteFromCache(string $objectId)
    {

    }
}
