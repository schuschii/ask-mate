<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Config;
use App\Core\Database;

try {
    Config::load(__DIR__ . '/../config/config.local.json');
    Database::connect();
    $pdo = Database::getConnection();

    // Load and execute schema.sql
    $schemaSql = file_get_contents(__DIR__ . '/../database/schema.sql');
    $pdo->exec($schemaSql);

    // Load and execute populate.sql
    $populateSql = file_get_contents(__DIR__ . '/../database/populate.sql');
    $pdo->exec($populateSql);

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
