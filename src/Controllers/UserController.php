<?php

namespace App\Controllers;

use App\Services\UserService;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct(new UserService());
    }
};
