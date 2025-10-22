<?php

namespace App\Controllers;

use App\Services\RoleService;

class RoleController extends Controller
{

    public function validateCreate($params): bool
    {
        return false;
    }

    public function getDefaultServiceName(): string
    {
        return 'role';
    }
}
