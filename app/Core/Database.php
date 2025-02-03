<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): void
    {
        if (self::$pdo === null) {
            try {
                $config = Config::get('database');

                $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
                self::$pdo = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch results as associative arrays
                    PDO::ATTR_PERSISTENT         => true // Persistent connection
                ]);
            } catch (PDOException $e) {
                die("Database Connection Failed: " . $e->getMessage());
            }
        }
    }

    public static function getConnection(): ?PDO
    {
        if (self::$pdo === null) {
            self::connect();
        }
        return self::$pdo;
    }
}
