<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\Factory\EntityFactory;

class UserService extends Service
{
    public function __construct()
    {
        parent::__construct(new UserRepository(), new EntityFactory());
    }
};
