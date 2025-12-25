<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Exception;

abstract class Controller
{
    protected $service;

    public function __construct()
    {
        $serviceName = $this->getDefaultServiceName();
        $serviceFQN = 'App\Services\\' . ucfirst($serviceName) . 'Service';
        $this->service = new $serviceFQN();
    }

    public function getEntityCollection(Request $request, Response $response, $args = []): Response
    {
        $params = $request->getQueryParams();
        $requestData = array_merge($params, $args);

        $result = $this->service->getEntityCollection($requestData);

        return $this->buildResponse($response, 200, $result);
    }

    public function getEntity(Request $request, Response $response, $args = []): Response
    {
        $params = $request->getQueryParams();
        $requestData = array_merge($params, $args);

        $entity = $this->service->getEntity($requestData);

        return $this->buildResponse($response, 200, $entity);
    }

    public function create(Request $request, Response $response, $args = []): Response
    {
        $requestDataContent = $request->getBody()->getContents();
        $requestData = \json_decode($requestDataContent, true);

        try {
            $this->validateCreate($requestData);
            $this->service->create($requestData);
        } catch (\Exception $e) {
            return $this->buildResponse($response, $e->getCode(), $e->getMessage());
        }

        return $this->buildResponse($response, 200, true);
    }

    public function delete(
        Request $request,
        Response $response,
        $args = []
    ) {
        // TODO: validate delete

        try {
            $this->service->delete($args);
        } catch (Exception $e) {
            return $this->buildResponse($response, $e->getCode(), $e->getMessage());
        }

        return $this->buildResponse($response, 200, true);
    }

    public function buildResponse(Response $response, $status, $data = []): Response
    {
        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(is_int($status) ? $status : 500);
    }

    abstract public function getDefaultServiceName(): string;
    abstract protected function validateCreate($params): bool;
};
