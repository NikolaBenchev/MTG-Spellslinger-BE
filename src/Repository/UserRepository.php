<?php
namespace App\Repository;

class UserRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'user';
    }
};
