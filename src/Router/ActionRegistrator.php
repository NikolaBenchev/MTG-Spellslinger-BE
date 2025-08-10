<?php

namespace App\Router;

use App\Router\AccessConfig;
use Slim\Routing\RouteCollectorProxy;

class ActionRegistrator
{
    public static function registerActions(
        RouteCollectorProxy $route,
        $controllerName,
        $existingRoutes,
        $pattern
    ) {
        $controllerFQN = 'App\Controllers\\' . ucfirst($controllerName) . 'Controller';

        //TODO: decide how and add needed middlewares ($pattern is for a potential middleware)
        if (in_array(AccessConfig::LIST, $existingRoutes)) {
            $listRoute = $route
                ->get('', $controllerFQN . ':getEntityCollection')
                ->setName("$controllerName.list");
        }

        if (in_array(AccessConfig::CREATE, $existingRoutes)) {
            $createRoute = $route
                ->post('', $controllerFQN . ':create')
                ->setName("$controllerName.create");
        }

        if (in_array(AccessConfig::GET, $existingRoutes)) {
            $getRoute = $route
                ->get('/{uuid}', $controllerFQN . ':getEntity')
                ->setName("$controllerName.get");
        }

        if (in_array(AccessConfig::UPDATE, $existingRoutes)) {
            $updateRoute = $route
                ->patch('/{uuid}', $controllerFQN . ':update')
                ->setName("$controllerFQN.update");
        }

        if (in_array(AccessConfig::DELETE, $existingRoutes)) {
            $deleteRoute = $route
                ->delete('/{uuid}', $controllerFQN . ':delete')
                ->setName("controllerFQN.delete");
        }
    }
}
