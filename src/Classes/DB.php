<?php

namespace App\Classes;

use PDO;

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

    public static function query(string $query, ?array $params = null): bool
    {
        $statement = self::$connection->prepare($query);

        foreach ($params ?? [] as $key => $value) {
            $type = PDO::PARAM_STR;

            if (gettype($value) === "integer") {
                $type = PDO::PARAM_INT;
            }

            $statement->bindValue($key, $value, $type);
        }

        if (!$statement) {
            return false;
        }

        return $statement->execute();
    }

    public static function fetch(string $query): mixed
    {
        $result = self::$connection->query($query);

        if (!$result) {
            return null;
        }

        $fetch = $result->fetch(PDO::FETCH_ASSOC);

        if (!$fetch) {
            return null;
        }

        return $fetch;
    }

    public static function fetchAll(string $query): bool|array
    {
        $result = self::$connection->query($query);

        if (!$result) {
            return false;
        }

        return $result->fetchAll(PDO::FETCH_ASSOC);
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
}