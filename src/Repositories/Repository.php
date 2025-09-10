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
        $columns = $params['columns'] ?? [];
        unset($params['columns']);

        return $this->database->selectAll($this->table, $columns, $params);
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

    public function delete($params)
    {
        return $this->database->delete($this->table, $params);
    }

    public function exists($params) {
        return $this->database->exists($this->table, $params);
    }

    public abstract function getEntityName(): string;
};
