<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Services\Service;
use Exception;

abstract class Controller
{
    protected Service $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function getEntityCollection(Request $request, Response $response, $args = []): Response
    {
        $result = $this->service->getEntityCollection($request, $response, $args);

        return $this->buildResponse($response, 200, $result);
    }

    public function create(Request $request, Response $response, $args = []): Response
    {
        try {
            $this->service->create();
        } catch (Exception $e) {
            throw $e;
            return $this->buildResponse($response, $e->getCode(), $e->getMessage());
        }

        return $this->buildResponse($response, 200, true);
    }

    public function buildResponse(Response $response, $status, $data = []): Response
    {
        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus($status);
    }
};
