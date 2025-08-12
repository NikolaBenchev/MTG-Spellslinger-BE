<?php

namespace App\Services;

use App\Repositories\Repository;
use App\Factory\EntityFactory;

abstract class Service
{
    protected Repository $repository;
    protected EntityFactory $entityFactory;

    public function __construct()
    {
        $repositoryName = $this->getDefaultRepositoryName();
        $repositoryFQN = 'App\Repositories\\' . ucfirst($repositoryName) . 'Repository';

        $this->repository = new $repositoryFQN();
        $this->entityFactory = new EntityFactory();
    }

    public function getEntityCollection($params)
    {
        $result = $this->repository->selectAll([]);
        $entityCollection = [];

        foreach ($result as $entityData) {
            $entityName = $this->repository->getEntityName();
            $entityFQN = 'App\Entities\\' . ucfirst($entityName) . 'Entity';
            $entity = EntityFactory::createEntityFromDatabase(
                $entityFQN,
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

    public function create($requestData)
    {
        $entity = EntityFactory::createEntityFromRequest(
            $this->repository->getEntityName(),
            $requestData
        );


        $lastInsertedUuid = $this->repository->create($entity->getDatabaseParams());
        if ($lastInsertedUuid != 0) {
            $entity->setUuid($lastInsertedUuid);
        }

        return $entity;
    }

    public function getBy($params)
    {
        return $this->repository->selectOne([
            'filter' => $params
        ]);
    }

    public function delete($args)
    {
        return $this->repository->delete([
            'filter' => $args
        ]);
    }

    abstract public function getDefaultRepositoryName(): string;
};
