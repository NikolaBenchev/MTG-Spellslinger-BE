<?php

use Slim\Factory\AppFactory;
use Predis\Client as PredisClient;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db_config.php';

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');


$app = AppFactory::create();

// TODO: use constants or even .env variables
$redis = new PredisClient([
    'scheme'   => 'tcp',
    'host'     => '127.0.0.1',
    'port'     => 6379,
    'password' => '',
    'database' => 0,
]);

require __DIR__ . '/../routes.php';

$app->run();
