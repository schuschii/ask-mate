<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Template;
use App\Models\Answer;
use App\Repositories\AnswerRepository;

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


    public function create( $question_id): void
    {
        $questionInt = (int)$question_id;

        $this->render('answer.create', ['question_id' => $questionInt]);
    }


    public function store($question_id): void
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Method Not Allowed");
        }

        if (!isset($_POST['question_id'], $_POST['message'])) {
            die("Invalid request. Missing fields.");
        }
        $user_id = $_SESSION['user_id'] ?? 1;

        $answer = new Answer(
            (int)$question_id,
            $user_id,
            trim($_POST['message']),
            0
        );
        var_dump($answer);

        $this->answerRepository->save($answer);


        header("Location: /questions");
        exit;
    }


    public function editAnswer($id): void
    {

        $answer = $this->answerRepository->find($id);

        if (!$answer) {
            http_response_code(404);
            die("Answer not found.");
        }

        // Render edit page with answer data
        $this->render('answer.edit', ['answer' => $answer]);
    }

    public function updateAnswer($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Method Not Allowed");
        }

        if (!isset($_POST['id'], $_POST['message'])) {
            die("Invalid request. Missing fields.");
        }


        $answer = $this->answerRepository->find($id);

        if (!$answer) {
            http_response_code(404);
            die("Answer not found.");
        }

        $answer->message = htmlentities(trim($_POST['message']));

        $this->answerRepository->update($answer);

        header("Location: /answers/list/{$answer->id_question}");
        exit;
    }

    public function deleteAnswer($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Step 1: Show the delete confirmation page
            if (!isset($_GET['id'])) {
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
            if (!isset($_POST['id'], $_POST['question_id'])) {
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
            header("Location: /answers/list/{$_POST['question_id']}");
            exit;
        } else {
            http_response_code(405);
            die("Method Not Allowed");
        }
    }


}