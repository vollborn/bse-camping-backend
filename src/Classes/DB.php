<?php

namespace App\Classes;

use Exception;
use PDO;
use PDOStatement;

class DB
{
    private static PDO $connection;

    public static function connect(): void
    {
        $dsn = sprintf(
            'mysql:dbname=%s;host=%s',
            $_ENV['DB_DATABASE'],
            $_ENV['DB_HOSTNAME']
        );

        self::$connection = new PDO(
            $dsn,
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD']
        );
    }

    public static function query(string $query, ?array $params = null): PDOStatement
    {
        $statement = self::$connection->prepare($query);
        if (!$statement) {
            throw new Exception("The query was not successful.");
        }

        self::bindValues($statement, $params);

        if(!$statement->execute()) {
            throw new Exception("The query was not successful.");
        }

        return $statement;
    }

    public static function fetch(string $query, ?array $params = null): mixed
    {
        $statement = self::$connection->prepare($query);

        if (!$statement) {
            return null;
        }

        self::bindValues($statement, $params);
        
        $statement->execute();
        $fetch = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$fetch) {
            return null;
        }

        return $fetch;
    }

    public static function fetchAll(string $query, ?array $params = null): bool|array
    {
        $statement = self::$connection->prepare($query);

        if (!$statement) {
            return false;
        }

        self::bindValues($statement, $params);

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function migrate(): void
    {
        $basePath = __DIR__ . '/../Migrations';
        $files = array_diff(scandir($basePath), array('..', '.'));;

        $query = "";

        foreach ($files as $file) {
            $query .= file_get_contents($basePath . '/' . $file);
        }

        self::query($query);
    }

    public static function lastInsertId(): int
    {
        return self::$connection->lastInsertId();
    }

    private static function bindValues(PDOStatement $statement, ?array $params = null): void
    {
        foreach ($params ?? [] as $key => $value) {
            $type = PDO::PARAM_STR;

            if (gettype($value) === "integer") {
                $type = PDO::PARAM_INT;
            }

            $statement->bindValue($key, $value, $type);
        }
    }
}