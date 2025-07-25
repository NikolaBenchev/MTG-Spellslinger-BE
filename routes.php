<?php

include __DIR__ . '/src/Controllers/UserController.php';

$userControllerName = "App\Controllers\UserController";

$app->get('/', "$userControllerName:getEntityCollection");
