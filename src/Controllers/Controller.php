<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Services\Service;
use Exception;

abstract class Controller
{
    protected Service $service;

    public function __construct()
    {
        $serviceName = $this->getDefaultServiceName();
        $serviceFQN = 'App\Services\\' . ucfirst($serviceName) . 'Service';
        $this->service = new $serviceFQN();
    }

    public function getEntityCollection(Request $request, Response $response, $args = []): Response
    {
        $params = $request->getQueryParams();
        $params = array_merge($params, $args);

        $result = $this->service->getEntityCollection($params);

        return $this->buildResponse($response, 200, $result);
    }

    public function create(Request $request, Response $response, $args = []): Response
    {
        $requestDataContent = $request->getBody()->getContents();
        $requestData = \json_decode($requestDataContent, true);

        //TODO: validate create

        try {
            $this->service->create($requestData);
        } catch (Exception $e) {
            throw $e;
            return $this->buildResponse($response, $e->getCode(), $e->getMessage());
        }

        return $this->buildResponse($response, 200, true);
    }

    public function getBy(
        Request $request, 
        Response $response, 
        $args = []
    ) {
        $params = $request->getQueryParams();
        $params = array_merge($params, $args);
        
        $this->service->getBy($params);
    }

    public function buildResponse(Response $response, $status, $data = []): Response
    {
        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus($status);
    }

    abstract public function getDefaultServiceName(): string;
};
