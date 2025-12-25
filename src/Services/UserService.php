<?php

namespace App\Services;

use App\Entities\RoleEntity;

class UserService extends Service
{
    private RoleService $roleService;

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

        $requestData['roleUuid'] = $this->roleService->getEntity([
            'name' => $requestData['role']
        ])->getUuid();

        unset($requestData['repeatPassword']);
        unset($requestData['role']);

        $requestData['password'] = password_hash($requestData['password'], PASSWORD_DEFAULT);

        return parent::create($requestData);
    }

    public function login($requestData = [])
    {
        $userData = $this->repository->select($requestData, true);
        if (empty($userData))
            throw new \Exception('Wrong email or password!', 401);

        unset($userData['password']);

        session_regenerate_id();
        $_SESSION['userData'] = $userData;
        $_SESSION['isAuthenticated'] = true;

        return $_SESSION;
    }

    public function logout($sessionUuid)
    {
        // $this->redis->delete("users/$sessionUuid");
    }

    public function checkAuth()
    {
        return [
            'userUuid' => $_SESSION['userData']['uuid'] ?? null,
            'isAuthenticated' => $_SESSION['isAuthenticated'] ?? false
        ];
    }
};
