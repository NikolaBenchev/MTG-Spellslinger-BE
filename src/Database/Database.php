<?php

namespace App\Database;

use App\Helpers\Helper;
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
            (empty($columns) ? '* ' : implode(',', $columns))
            . "FROM $tableName";

        $additionalParamsObj = $this->parseAdditionalParams($params);

        $queryString .= $additionalParamsObj['query'];

        $query = $this->pdo->prepare($queryString);
        $query->execute($additionalParamsObj['params']);

        return $query->fetchAll();
    }

    public function insert($tableName, $params = [])
    {
        $placeholders = array_fill(0, count($params), '?');

        $queryString = "INSERT INTO 
            $tableName(" . implode(',', array_keys($params)) . ') 
            VALUES(' . implode(',', $placeholders) . ')';

        $query = $this->pdo->prepare($queryString);
        $query->execute(array_values($params));

        return $this->pdo->lastInsertId();
    }

    public function delete($tableName, $params)
    {
        //TODO: transaction
        $queryString = "DELETE FROM $tableName";

        $additionalParamsObj = $this->parseAdditionalParams($params);

        $queryString .= $additionalParamsObj['query'];

        $query = $this->pdo->prepare($queryString);
        return $query->execute($additionalParamsObj['params']);
    }

    public function exists($tableName, $params)
    {
        $queryString = "SELECT 1 FROM $tableName";
        $additionalParamsObj = $this->parseAdditionalParams($params);
        $queryString .= $additionalParamsObj['query'];
        $queryString .= ' LIMIT 1';

        $query = $this->pdo->prepare($queryString);

        $query->execute($additionalParamsObj['params']);
        return $query->fetch();
    }

    private function parseAdditionalParams($params): array
    {
        $filterString = '';
        /*
            uuid, name, colors, commander, cards?, owned cards?

            mtg-spellslinger.whf.bz/decks?filter[cards]=[{cards}]
        */
        if (!empty($params['filter'])) {
            $filterString = ' WHERE ';
            $index = 0;
            foreach (array_keys($params['filter']) as $key) {
                $filterString .= ($index === 0 ? '' : ' AND') . " $key=:$key";
                $index++;
            }
        }

        $groupString = '';
        if (!empty($params['group'])) {
            $groupString = ' GROUP BY ' . str_repeat('?,', count($params['group'])) . '?';
        }

        $orderString = '';
        if (!empty($params['order'])) {
            $orderString = ' ORDER BY ' . str_repeat('?,', count($params['order'])) . '?';
        }

        return [
            'query' => $filterString . $groupString . $orderString,
            'params' => array_merge(
                $params['filter'] ?? [],
                $params['group'] ?? [],
                $params['order'] ?? []
            )
        ];
    }
};
