<?php

namespace App\Services;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Repository\Repository;
use App\Factory\EntityFactory;

abstract class Service
{
    protected Repository $repository;
    protected EntityFactory $entityFactory;

    public function __construct(Repository $repository, EntityFactory $entityFactory)
    {
        $this->repository = $repository;
        $this->entityFactory = $entityFactory;
    }

    // TODO: maybe change parameters to $requestData only
    public function getEntityCollection(Request $request, Response $response, $args = [])
    {
        $result = $this->repository->selectAll([]);
        $entityCollection = [];

        foreach ($result as $entityData) {
            $entity = $this->entityFactory->createEntityFromDatabase(
                $this->repository->getEntityName(), 
                $entityData
            );

            array_push($entityCollection, $entity);
        }

        return [
            'list' => $entityCollection,
            'pagination' => [
                'totalCount' => 1,
                'limit' => 1,
                'page' => 0
            ]
        ];
    }

    public function create()
    {
        return true;
    }
};
