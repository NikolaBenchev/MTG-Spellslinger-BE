<?php

namespace App\Repository;

use App\Database\Database;

abstract class Repository
{
    protected Database $database;
    protected string $table;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function selectAll($requestData)
    {
        return $this->database->selectAll($this->table);
    }
};
