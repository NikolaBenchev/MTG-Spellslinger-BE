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
        $queryString = 'SELECT ' .
            (empty($columns) ? "* " : implode(',', $columns))
            . "FROM $tableName";

        $queryString .= $this->parseAdditionalParams($params);

        $query = $this->pdo->prepare($queryString);
        $query->execute();

        return $query->fetchAll();
    }

    private function parseAdditionalParams($params): string
    {
        $filterString = '';
        /*
            uuid, name, colors, commander, cards?, owned cards?

            mtg-spellslinger.whf.bz/decks?filter[cards]=[{cards}]
        */
        if(!empty($params['filter'])) {
            $filterString = ' WHERE ';
            $index = 0;
            foreach(array_keys($params['filter']) as $key) {
                $filterString .= ($index !== 0 && ' AND') . " $key=" . $params['filter'][$key];
                $index++;
            }
        }
        

        $groupString = '';
        if(!empty($params['group'])) {
            $groupString = ' GROUP BY ' . implode(',', $params['group']);
        }

        $orderString = '';
        if(!empty($params['order'])) {
            $orderString = ' ORDER BY ' . implode(',', $params['order']);
        }

        return $filterString . $groupString . $orderString;
    }
};
