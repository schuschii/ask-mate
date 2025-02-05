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
use App\Controllers\QuestionController;
use App\Controllers\AnswerController;

$router = new Router($pdo);

// Define routes

$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/home', [HomeController::class, 'index']);
//bade template:
$router->add('GET', '/user/register', [UserController::class, 'createUser']);
//actually passing data here:
$router->add('POST', '/user/register', [UserController::class, 'saveUser']);
$router->add('GET', '/user/login', [UserController::class, 'login']);

$router->add('GET', '/user/{id}', [UserController::class, 'showUser']);
$router->add('GET', '/questions', [QuestionController::class, 'showQuestions']);
$router->add('GET', '/answers/list/{question_id}', [AnswerController::class, 'showAnswers']);
$router->add('GET', '/create/{question_id}', [AnswerController::class, 'create']);
$router->add('POST', '/answers/post/{question_id}', [AnswerController::class, 'store']);
$router->add('POST', '/delete/answer_id/{id}', [AnswerController::class, 'deleteAnswer']);
$router->add('GET', '/answer/edit/id/{id}', [AnswerController::class, 'editAnswer']);
$router->add('post', '/answer/update/id/{id}', [AnswerController::class, 'updateAnswer']);

// Dispatch the request
$router->dispatch();

// Run with "php -S localhost:8000 -t public"
/*$controller = new HomeController();
$controller1 = new AnswerController();

$controller->index();

$controllerQuestion = new QuestionController($pdo);
$controllerQuestion->showQuestions();
$controllerQuestion->showQuestion(2);
$controllerQuestion->addQuestion();

//delete should be called via router
//update should be called via router


$controller1->updateAnswer();*/