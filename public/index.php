<?php

require __DIR__ . '/../vendor/autoload.php';


use App\Test;

$test = new Test();
$test->sayHello();
//------------------------//



use App\Core\Config;
use App\Core\Database;

Config::load(__DIR__ . '/../config/config.local.json');

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


use App\Core\Router;
use App\Controllers\UserController;
use App\Controllers\HomeController;
use App\Controllers\AnswerController;

$router = new Router();

// Define routes
$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/user/{id}', [UserController::class, 'showUser']);

// Dispatch the request
$router->dispatch();

// Run with "php -S localhost:8000 -t public"
$controller = new HomeController();
$controller1 = new AnswerController();

$controller->index();

$controller1->updateAnswer();