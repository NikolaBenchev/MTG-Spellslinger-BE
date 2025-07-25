<?php

namespace App\Services;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Repository\Repository;

abstract class Service
{
    protected Repository $repository;
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function getEntityCollection(Request $request, Response $response, $args = []) {}
};
