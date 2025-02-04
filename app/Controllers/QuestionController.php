<?php

namespace GlobalNamespace {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

namespace App\Controllers {

    use App\Contracts\QuestionRepository;
    use App\Core\Controller;
    use PDO;

    class QuestionController extends Controller
    {

        private $repository;

        public function __construct(PDO $connection){
            parent::__construct();
            $this->repository = new QuestionRepository($connection);
        }

        public function showQuestions(): void
        {
            $questions = $this->repository->findAll(); //returns array of question objs
            $this->render('questions', [
                'title' => 'List all questions',
                'questions' => $questions
            ]);
        }

    }
}