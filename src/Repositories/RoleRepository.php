<?php

namespace App\Repositories;

class RoleRepository extends Repository {
    public function __construct()
    {
        parent::__construct();
        $this->table = 'role';   
    }

    public function getEntityName(): string
    {
        return 'role';
    }
}