<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Answer;
use App\Repositories\AnswerRepository;
use App\Core\SuperGlobalManager;

class AnswerController extends Controller
{
    private AnswerRepository $answerRepository;

    public function __construct()
    {
        parent::__construct();
        $this->answerRepository = new AnswerRepository();
    }



    public function showAnswers(int $question_id): void
    {
        $answers = $this->answerRepository->findByQuestion($question_id);

        $this->render('answer.list', ['answers' => $answers]);
    }


    public function create(int $question_id): void
    {

        $this->render('answer.create', ['question_id' => $question_id]);
    }


    public function store(int $question_id): void
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Method Not Allowed");
        }

        // Use SuperGlobalManager to get request data safely
        $question_id_from_request = SuperGlobalManager::getRequest('question_id');
        $message = SuperGlobalManager::getRequest('message');

        if (!$question_id_from_request || !$message) {
            die("Invalid request. Missing fields.");
        }

        $user_id = SuperGlobalManager::getSession('user_id', 1);

        $answer = new Answer(
            $question_id,
            $user_id,
            trim($_POST['message']),
            0
        );

        $this->answerRepository->save($answer);


        header("Location: /questions");
        exit;
    }


    public function editAnswer(int $id): void
    {

        $answer = $this->answerRepository->find($id);

        if (!$answer) {
            http_response_code(404);
            die("Answer not found.");
        }

        // Render edit page with answer data
        $this->render('answer.edit', ['answer' => $answer]);
    }

    public function updateAnswer(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Method Not Allowed");
        }

        // Use SuperGlobalManager to get request data safely
        $answer_id_from_request = SuperGlobalManager::getRequest('id');
        $message = SuperGlobalManager::getRequest('message');

        if (!$answer_id_from_request || !$message) {
            die("Invalid request. Missing fields.");
        }


        $answer = $this->answerRepository->find($id);

        if (!$answer) {
            http_response_code(404);
            die("Answer not found.");
        }

        $answer->message = htmlentities(trim($message));

        $this->answerRepository->update($answer);

        header("Location: /answers/list/{$answer->id_question}");
        exit;
    }

    public function deleteAnswer(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            // Step 1: Show the delete confirmation page

            $answer_id_from_request = SuperGlobalManager::getRequest('id');

            if (!$answer_id_from_request) {
                http_response_code(400);
                die("Invalid request. Missing answer ID.");
            }

            $answer = $this->answerRepository->find($id);

            if (!$answer) {
                http_response_code(404);
                die("Answer not found.");
            }


            $this->render('answer.delete', ['answer' => $answer]);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Step 2: Handle the actual deletion

            $answer_id_from_post = SuperGlobalManager::getRequest('id');
            $question_id_from_post = SuperGlobalManager::getRequest('question_id');

            if (!$answer_id_from_post || !$question_id_from_post) {
                http_response_code(400);
                die("Invalid request.");
            }

            $answer = $this->answerRepository->find($id);

            if (!$answer) {
                http_response_code(404);
                die("Answer not found.");
            }


            $this->answerRepository->delete($id);

            // Redirect back to the question page
            header("Location: /answers/list/{$question_id_from_post}");
            exit;
        } else {
            http_response_code(405);
            die("Method Not Allowed");
        }
    }


}