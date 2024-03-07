<?php

namespace App\Services;

use App\Exceptions\RedisException;
use App\Utils\RedisConnection;
use Predis\Client;

class TokenStorageService
{
    private Client $redis;
    public function __construct()
    {
        $this->redis = RedisConnection::makeConnection();
    }

    public function save(string $token, int $userId): void
    {
        $timeToRefresh = (int)config('jwt.ttr');
        $this->redis->set($token, $userId, 'EX', $timeToRefresh);
    }

    /**
     * @throws RedisException
     */
    public function delete(string $token): void
    {
        if ($this->redis->del($token) === 0) {
            throw RedisException::failedToDelete();
        }
    }

    /**
     * @throws RedisException
     */
    public function find(string $token): string
    {
        $value = $this->redis->get($token);
        if (!$value) {
            throw RedisException::failedToFindToken();
        }
        return $value;
    }
}
