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

    public function select($params, $selectOne = false)
    {
        $columns = $params['columns'] ?? [];
        unset($params['columns']);

        return $this->database->select($this->table, $columns, $params, $selectOne);
    }

    public function create($params)
    {
        $params['uuid'] = Uuid::uuid4()->toString();

        return $this->database->insert($this->table, $params);
    }

    public function delete($params)
    {
        return $this->database->delete($this->table, $params);
    }

    public function exists($params)
    {
        return $this->database->exists($this->table, $params);
    }

    public abstract function getEntityName(): string;
};
