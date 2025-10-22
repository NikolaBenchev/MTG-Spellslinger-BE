<?php

namespace App\Handlers;

use Predis\Client as RedisClient;
use SessionHandlerInterface;

class RedisSessionHandler implements SessionHandlerInterface
{
    private $redis;
    private $expiration;

    public function __construct(RedisClient $redis, int $expiration = 3600)
    {
        $this->redis = $redis;
        $this->expiration = $expiration;
    }

    public function read($key): string
    {
        $data = $this->redis->get("sessions:{$key}");
        return $data ?: '';
    }

    public function write($key, $data): bool
    {
        $this->redis->setex("sessions:{$key}", $this->expiration, $data);
        return true;
    }

    public function destroy($key): bool
    {
        $this->redis->del("sessions:{$key}");
        return true;
    }

    public function open($savePath, $sessionName): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function gc($key): int|false
    {
        return true;
    }
}
