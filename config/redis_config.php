<?php

use Predis\Client as RedisClient;
use Dotenv\Dotenv;
use App\Handlers\RedisSessionHandler;

$dotenv = Dotenv::createImmutable(__DIR__, '.env.dev');
$dotenv->load();

$redis = new RedisClient([
    'scheme'   => 'tcp',
    'host'     => $_ENV['REDIS_HOST'],
    'port'     => $_ENV['REDIS_PORT'],
    'password' => $_ENV['REDIS_PASS'],
    'database' => 0,
]);

session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => false, // TODO: set depending on environment (is https only)
    'httponly' => true,
    'samesite' => 'Lax',
]);

$handler = new RedisSessionHandler($redis);
session_set_save_handler($handler, true);

session_start();