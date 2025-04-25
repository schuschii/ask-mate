<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Config;
use App\Core\Database;

try {
    Config::load(__DIR__ . '/../config/config.local.json');

    $env = getenv('ENV') ?: 'production';

    Database::connect();
    $pdo = Database::getConnection();

    // Load
    $schemaSql = file_get_contents(__DIR__ . '/../database/schema.sql');
    $populateSql = file_get_contents(__DIR__ . '/../database/populate.sql');

    // Execute
    $pdo->exec($schemaSql);
    $pdo->exec($populateSql);

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
