<?php

require __DIR__ . '/../vendor/autoload.php';



use App\Test;

$test = new Test();
//$test->sayHello();

//------------------------//


use App\Core\Config;
use App\Core\Database;

Config::load(__DIR__ . '/../config/config.local.json');

Database::connect();

$pdo = Database::getConnection();

/*if ($pdo) {
    echo "✅ Database connection established successfully!<br>";
} else {
    echo "❌ Failed to connect to the database.";
}*/


use App\Core\Logger;

// Initialize logger
$logger = new Logger();

// Test different log levels
//$logger->info("Application started.");
//$logger->error("Something went wrong!", ["file" => "index.php", "line" => 23]);

//echo "✅ Logging system initialized. Check 'logs/app.log'!<br>";


use App\Core\Router;
use App\Controllers\UserController;
use App\Controllers\HomeController;
use App\Controllers\QuestionController;
use App\Controllers\AnswerController;
use App\Controllers\TagController;

$controller = new HomeController();
$controller->showNavbar();

$router = new Router($pdo);

// Define routes

//User routes
$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/home', [HomeController::class, 'index']);
//register
$router->add('GET', '/user/register', [UserController::class, 'createUser']);
//actually passing data here:
$router->add('POST', '/user/register', [UserController::class, 'saveUser']);
//login
$router->add('GET', '/user/login', [UserController::class, 'login']);
$router->add('POST', '/user/login', [UserController::class, 'loginUser']);

$router->add('GET', '/user/{id}', [UserController::class, 'showUser']);

// Needs logout route and method

// Question routes
$router->add('GET', '/questions', [QuestionController::class, 'showQuestions']);
$router->add('GET', '/question/add', [QuestionController::class, 'showAddQuestion']);
$router->add('POST', '/question/add', [QuestionController::class, 'addQuestion']);
$router->add('GET', '/question/{id}', [QuestionController::class, 'showQuestion']);

$router->add('POST', '/question/delete/{id}', [QuestionController::class, 'deleteQuestion']);

$router->add('GET', '/question/edit/{id}', [QuestionController::class, 'showEditQuestion']);
$router->add('POST', '/question/edit/{id}', [QuestionController::class, 'updateQuestion']);

//Answer routes
$router->add('GET', '/answers/list/{question_id}', [AnswerController::class, 'showAnswers']);
$router->add('GET', '/create/{question_id}', [AnswerController::class, 'create']);
$router->add('POST', '/answers/post/{question_id}', [AnswerController::class, 'store']);

$router->add('POST', '/delete/answer_id/{id}', [AnswerController::class, 'deleteAnswer']);

$router->add('GET', '/answer/edit/id/{id}', [AnswerController::class, 'editAnswer']);
$router->add('post', '/answer/update/id/{id}', [AnswerController::class, 'updateAnswer']);
//search?q=PHP
$router->add('GET', '/search', [QuestionController::class, 'search']);


// Tag routes
$router->add('GET', '/tags', [TagController::class, 'showTags']);
$router->add('GET', '/tag/create', [TagController::class, 'showCreateTagForm']);
$router->add('POST', '/tag/create', [TagController::class, 'createTag']);
$router->add('POST', '/question/{id}/addTag', [TagController::class, 'addTagToQuestion']);
$router->add('POST', '/question/{id}/removeTag', [TagController::class, 'removeTagFromQuestion']);
$router->add('POST', '/tag/remove/{id}', [TagController::class, 'removeTag']);


// Dispatch the request
$router->dispatch();

// Run with "php -S localhost:8000 -t public"