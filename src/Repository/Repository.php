<?php
namespace App\Repository;

use PDO;

abstract class Repository
{
    protected PDO $pdo;
    protected string $table;
    public function __construct()
    {
        $settings = DB_SETTINGS;
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $settings['host'],
            $settings['database'],
            $settings['charset']
        );
        $this->pdo = new PDO($dsn, $settings['username'], $settings['password'], $settings['flags']);
    }

    public function selectAll($requestData)
    {
        $sql = "SELECT * FROM $this->table";

        return $this->pdo->query($sql);
    }
};
