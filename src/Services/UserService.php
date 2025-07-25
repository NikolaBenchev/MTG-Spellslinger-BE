<?php

namespace App\Services;

use App\Repository\UserRepository;

class UserService extends Service
{
    public function __construct()
    {
        parent::__construct(new UserRepository());
    }
};
