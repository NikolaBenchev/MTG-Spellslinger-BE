<?php

namespace App\Repositories;

use App\Database\Database;
use Ramsey\Uuid\Nonstandard\Uuid;

abstract class Repository
{
    protected Database $database;
    protected string $table;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function selectAll($params)
    {
        // TODO: use request data to select only specific columns, add filters or groups to the query
        return $this->database->selectAll($this->table);
    }

    public function selectOne($params) 
    {
        return $this->database->selectAll($this->table, [], $params)[0];
    }

    public function create($params)
    {
        $params['uuid'] = Uuid::uuid4()->toString();

        return $this->database->insert($this->table, $params);
    }

    public abstract function getEntityName(): string;
};
