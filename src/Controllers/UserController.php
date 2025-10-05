<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Entities\RoleEntity;

class UserController extends Controller
{
    public function getDefaultServiceName(): string
    {
        return 'user';
    }

    protected function validateCreate($params): bool
    {
        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL))
            throw new \Exception('Email is not valid', 400);
        if (key_exists('role', $params) && !array_key_exists($params['role'], RoleEntity::ROLES))
            throw new \Exception('Requested role does not exist', 400);
        if ($this->service->exists([
            'filter' => [
                'username' => $params['username'],
                'email' => $params['email']
            ]
        ]))
            throw new \Exception('User with this email or username already exists.', 409);

        return true;
    }

    public function login(Request $request, Response $response, $args = [])
    {
        $requestDataContent = $request->getBody()->getContents();
        $requestData = \json_decode($requestDataContent, true);

        $this->service->login($requestData);
        return $this->buildResponse($response, 200, []);
    }
};
