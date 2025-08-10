<?php

namespace App\Factory;

use App\Helpers\Helper;
use App\Entities\UserEntity;

class EntityFactory
{
    public static function createEntityFromRequest(string $entityName, array $requestData)
    {
        $entityFQN = 'App\Entities\\' . ucfirst($entityName) . 'Entity';
        $entity = new $entityFQN();


        foreach ($requestData as $key => $value) {
            if (property_exists($entity, $key)) {
                $method = 'set' . ucfirst($key);
                $entity->{$method}($value);
            }
        }

        return $entity;
    }

    public static function createEntityFromDatabase(string $entityName, array $data)
    {
        $entity = new $entityName();

        if (empty($data))
            return $entity;

        foreach ($data as $key => $value) {
            $propertyName = Helper::underscoreToCamelCase($key);
            if (property_exists($entity, $propertyName)) {
                $method = 'set' . ucfirst($propertyName);
                $entity->{$method}($value);
            }
        }

        return $entity;
    }
};
