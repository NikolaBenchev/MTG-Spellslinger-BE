<?php

use App\Router\ActionRegistrator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteCollectorProxy;
use App\Router\AccessConfig;

include __DIR__ . '/src/Controllers/UserController.php';

$userControllerFQN = "App\Controllers\UserController";

$app->group(
    '',
    function (RouteCollectorProxy $route) use ($userControllerFQN) {
        $route->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
            $response->getBody()->write("MTG-Spellslinger API");
            return $response;
        });

        $route->group(
            '/users',
            function (RouteCollectorProxy $route) {
                ActionRegistrator::registerActions(
                    $route,
                    'user',
                    AccessConfig::getUserRoutes(),
                    '/users'
                );
            }
        );

        $route->post('/login', $userControllerFQN . ':login');

        $route->get('/checkAuth', $userControllerFQN . ':checkAuth');

        $route->get('/getUserData', $userControllerFQN . ':getEntity');
    }
);
