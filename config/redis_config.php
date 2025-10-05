<?php

use Predis\Client as RedisClient;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__, '.env.dev');
$dotenv->load();

$redis = new RedisClient([
    'scheme'   => 'tcp',
    'host'     => $_ENV['REDIS_HOST'],
    'port'     => $_ENV['REDIS_PORT'],
    'password' => $_ENV['REDIS_PASS'],
    'database' => 0,
]);