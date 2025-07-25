<?php

use Slim\Factory\AppFactory;
use Predis\Client as PredisClient;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db_config.php';


$app = AppFactory::create();

$redis = new PredisClient([
    'scheme'   => 'tcp',
    'host'     => '127.0.0.1',
    'port'     => 6379,
    'password' => '',
    'database' => 0,
]);


require __DIR__ . '/../routes.php';

$app->run();
