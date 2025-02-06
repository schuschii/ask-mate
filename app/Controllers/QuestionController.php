<?php

namespace GlobalNamespace {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

namespace App\Controllers {

    use App\Core\Controller;
    use App\Repositories\QuestionRepository;
    use PDO;

    class QuestionController extends Controller
    {

        private $repository;

        public function __construct(PDO $connection)
        {
            parent::__construct();
            $this->repository = new QuestionRepository($connection);
        }

        public function search(): void
        {
            $searchTerm = $_GET['q'] ?? ''; //searchTerm from URL
            $questions = $this->repository->searchQuestion($searchTerm);
            $this->render('questions', [
                'title' => 'List all matching questions',
                'questions' => $questions
            ]);
        }


        public function showQuestions(): void
        {
            $questions = $this->repository->findAll(); //returns array of question objs
            $this->render('questions', [
                'title' => 'List all questions',
                'questions' => $questions
            ]);
        }

        public function showAddQuestion(): void
        {
            $this->render('add-question', [
                'title' => 'Add a new question'
            ]);
        }


        // should superglobalmanager be used here???
        public function addQuestion(): void
        {
            $title = $_POST['title'] ?? '';
            $message = $_POST['message'] ?? '';

            if ($title && $message) {
                $question = (object)[
                    'title' => $title,
                    'message' => $message
                ];
                $this->repository->save($question);

                $newQuestionId = $this->repository->getLastInsertId();
                header("Location: /question/{$newQuestionId}");
                exit;
            }
            $this->render('add_question', [
                'title' => 'Add a new question',
                'error' => 'Please fill in all fields'
            ]);
        }

        public function showQuestion(int $id): void
        {
            $question = $this->repository->find($id);
            $this->render('question', [
                'title' => 'View Question',
                'question' => $question
            ]);
        }

        public function deleteQuestion(int $id): void
        {
            $this->repository->delete($id);
            header("Location: /questions");
            exit();
        }

        public function showEditQuestion(int $id): void
        {
            $question = $this->repository->find($id);
            if (!$question) {
                die("Question not found!");
            }

            $this->render('edit_question', ['title' => "Edit Question", 'question' => $question]);
        }


        public function updateQuestion(int $id): void
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title = $_POST['title'] ?? null;
                $message = $_POST['message'] ?? null;

                if ($title && $message) {
                    $question = $this->repository->find($id);
                    if (!$question) {
                        die("Question not found!");
                    }

                    $question->title = $title;
                    $question->message = $message;

                    $this->repository->update($question);

                    header("Location: /question/view/$id");
                    exit;
                }
            }

            header("Location: /question/edit/$id");
            exit;
        }
    }


}