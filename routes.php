<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

include __DIR__ . '/src/Controllers/UserController.php';

$userControllerName = "App\Controllers\UserController";

$app->get('/', function(ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write("MTG-Spellslinger API");
    return $response;
});

$app->get('/users', "$userControllerName:getEntityCollection");
