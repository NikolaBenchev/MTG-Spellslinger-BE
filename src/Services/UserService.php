<?php

namespace App\Services;

use App\Entities\RoleEntity;

class UserService extends Service
{
    private RoleService $roleService;
    // private RedisService $redisService;

    public function __construct()
    {
        parent::__construct();
        $this->roleService = new RoleService();
    }

    public function getDefaultRepositoryName(): string
    {
        return 'user';
    }

    public function create($requestData)
    {
        if (!isset($requestData['role'])) {
            $requestData['role'] = RoleEntity::USER;
        }

        $requestData['roleUuid'] = $this->roleService->getBy([
            'name' => $requestData['role']
        ])['uuid'];

        unset($requestData['repeatPassword']);
        unset($requestData['role']);

        $requestData['password'] = password_hash($requestData['password'], PASSWORD_DEFAULT);

        return parent::create($requestData);
    }

    public function login($requestData = [])
    {
        $userData = $this->repository->select($requestData, true);


    }
};
