<?php

namespace App\Repository;

use App\Database\Database;
use App\Factory\EntityFactory;

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
        // TODO: use request data to select only specific columns, add filters or groups to the query
        return $this->database->selectAll($this->table);
    }

    public function insert($requestData)
    {
        // return $this->database->insert();
    }

    public abstract function getEntityName();
};
