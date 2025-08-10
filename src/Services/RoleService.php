<?php

namespace App\Services;

class RoleService extends Service
{
    public function getBy($params)
    {
        return $this->repository->selectOne([
            'filter' => $params
        ]);
    }

    public function getDefaultRepositoryName(): string
    {
        return 'role';
    }
}
