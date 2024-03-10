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
    public function __construct(
        private readonly RedisStorageService $redisStorageService
    ) {}

    public function saveToCache(string $objectId, string $serializedObject): void
    {
        $timeToLive = 60;
        $this->redisStorageService->save($objectId, $serializedObject, $timeToLive);
    }

    public function getFromCache(string $objectId): ?string
    {
        return $this->redisStorageService->find($objectId);
    }

    public function deleteFromCache(string $objectId): void
    {
        $this->redisStorageService->delete($objectId);
    }
}
