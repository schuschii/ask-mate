<?php

namespace GlobalNamespace {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

namespace App\Controllers {

    use App\Core\Controller;
    use App\Repositories\QuestionRepository;

    class QuestionController extends Controller
    {

        private questionRepository $questionRepository;

        public function __construct()
        {
            parent::__construct();
            $this->questionRepository = new QuestionRepository();
        }

        public function showQuestions(): void
        {
            $questions = $this->questionRepository->findAll(); //returns array of question objs
            $this->render('question.questions', [
                'title' => 'List all questions',
                'questions' => $questions
            ]);
        }

        public function showAddQuestion(): void
        {
            $this->render('question.add_question', [
                'title' => 'Add a new question'
            ]);
        }


        // should superglobalmanager be used here???
        public function addQuestion(): void
        {
            $title = $_POST['title'] ?? '';
            $message = $_POST['message'] ?? '';
            $user_id = $_SESSION['user_id'] ?? 1;

            if ($title && $message) {
                $question = (object)[
                    'title' => $title,
                    'message' => $message,
                    'id_registered_user' => $user_id
                ];
                $this->questionRepository->save($question);

                $newQuestionId = $this->questionRepository->getLastInsertId();
                header("Location: /question/{$newQuestionId}");
                exit;
            }
            $this->render('question.add_question', [
                'title' => 'Add a new question',
                'error' => 'Please fill in all fields'
            ]);
        }

        public function showQuestion(int $id): void
        {
            $question = $this->questionRepository->find($id);


            $this->render('question.details', [
                'title' => 'View Question',
                'question' => $question
            ]);
        }

        public function deleteQuestion(int $id): void
        {
            $this->questionRepository->delete($id);
            header("Location: /questions");
            exit();
        }

        public function showEditQuestion(int $id): void
        {
            $question = $this->questionRepository->find($id);
            if (!$question) {
                die("Question not found!");
            }

            $this->render('question.edit_question', ['title' => "Edit Question", 'question' => $question]);
        }


        public function updateQuestion(int $id): void
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title = $_POST['title'] ?? null;
                $message = $_POST['message'] ?? null;

                if ($title && $message) {
                    $question = $this->questionRepository->find($id);
                    if (!$question) {
                        die("Question not found!");
                    }

                    $question->title = $title;
                    $question->message = $message;

                    $this->questionRepository->update($question);

                    header("Location: /question/$id");
                    exit;
                }
            }

            header("Location: /question/edit/$id");
            exit;
        }
    }


}