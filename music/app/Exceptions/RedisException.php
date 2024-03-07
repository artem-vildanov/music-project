<?php

namespace App\Exceptions;

class RedisException extends \Exception
{
    public static function failedToDelete(): RedisException
    {
        return new self("failed to delete token", 500);
    }

    public static function failedToFindToken(): RedisException
    {
        return new self('failed to find token', 500);
    }
}
