<?php

require __DIR__ . '/vendor/autoload.php';

use App\Test;

$test = new Test();
$test->sayHello();
//------------------------//



use App\Core\Config;
use App\Core\Database;

Config::load(__DIR__ . '/config/config.local.json');

Database::connect();

$pdo = Database::getConnection();

if ($pdo) {
    echo "✅ Database connection established successfully!<br>";
} else {
    echo "❌ Failed to connect to the database.";
}


use App\Core\Logger;

// Initialize logger
$logger = new Logger();

// Test different log levels
$logger->info("Application started.");
$logger->error("Something went wrong!", ["file" => "index.php", "line" => 23]);

echo "✅ Logging system initialized. Check 'logs/app.log'!<br>";


use App\Controllers\HomeController;
use App\Controllers\QuestionController;

$controller = new HomeController();
$controller->index();

$controllerQuestion = new QuestionController($pdo);
$controllerQuestion->showQuestions();
$controllerQuestion->showQuestion(2);
$controllerQuestion->addQuestion();

