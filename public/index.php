<?php

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db_config.php';
require __DIR__ . '/../config/redis_config.php';

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

// $container = new Container();
// AppFactory::setContainer($container);
$app = AppFactory::create();

require __DIR__ . '/../routes.php';

$app->run();
