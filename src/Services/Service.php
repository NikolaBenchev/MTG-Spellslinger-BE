<?php

namespace App\Services;

use App\Factory\EntityFactory;

abstract class Service
{
    protected $repository;
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
        $result = $this->repository->select($params);
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

    public function create($params)
    {
        $entity = EntityFactory::createEntityFromRequest(
            $this->repository->getEntityName(),
            $params
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

    public function exists($params) {
        return $this->repository->exists($params);
    }

    abstract public function getDefaultRepositoryName(): string;
};
