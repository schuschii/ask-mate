<?php

namespace GlobalNamespace {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

namespace App\Controllers {

    use App\Core\Controller;
    use App\Models\Question;
    use App\Repositories\QuestionRepository;
    use App\Core\SuperGlobalManager;

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


        public function addQuestion(): void
        {
            $title = SuperGlobalManager::getRequest('title', ''); // Get POST['title']
            $message = SuperGlobalManager::getRequest('message', ''); // Get POST['message']
            $user_id = SuperGlobalManager::getSession('user_id', 1); // Get SESSION['user_id']

            if ($title && $message) {

                $question = new Question (
                    0,
                    $user_id,
                $title,
                $message,
                0
                );

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

                $title = SuperGlobalManager::getRequest('title');
                $message = SuperGlobalManager::getRequest('message');

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