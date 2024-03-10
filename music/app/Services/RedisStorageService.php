<?php

namespace App\Services;

use App\Exceptions\RedisException;
use App\Utils\RedisConnection;
use Predis\Client;

class RedisStorageService
{
    private Client $redis;
    public function __construct()
    {
        $this->redis = RedisConnection::makeConnection();
    }

    public function save(string $key, string $value, int $timeToLive): void
    {
        $this->redis->set($key, $value, 'EX', $timeToLive);
    }

    public function delete(string $key): bool
    {
        return (bool)$this->redis->del($key);
    }

    public function find(string $key): ?string
    {
        return $this->redis->get($key);
    }
}
