<?php
namespace App\Repositories;

class UserRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'user';
    }

    public function getEntityName(): string
    {
        return 'user';
    }
};
