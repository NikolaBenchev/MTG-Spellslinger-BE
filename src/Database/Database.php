<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        try {
            $settings = DB_SETTINGS;
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $settings['host'],
                $settings['database'],
                $settings['charset']
            );
            $this->pdo = new PDO($dsn, $settings['username'], $settings['password'], $settings['flags']);
        } catch (PDOException $e) {
            die("Connection failed " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    public function selectAll($tableName, $columns = [], $params = [])
    {
        $queryString = "SELECT * FROM $tableName";
        $query = $this->pdo->prepare($queryString);
        $query->execute();

        return $query->fetchAll();
    }
};
