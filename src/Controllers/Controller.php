<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Services\Service;

abstract class Controller
{
    protected Service $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function getEntityCollection(Request $request, Response $response, $args = [])
    {
        $result = $this->service->getEntityCollection($request, $response, $args);

        return $this->buildSuccessResponse($response, 200, $result);
    }

    public function buildSuccessResponse(Response $response, $status, $data = []): Response
    {
        $response->getBody()->write(json_encode($data));

        return $response->withStatus($status);
    }
};
