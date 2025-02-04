<?php

namespace App\Controllers;

use App\Core\Controller;
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

    public function listAnswers(): void
    {
        $answers = $this->answerRepository->findAll();
        $this->render('answer.list', ['answers' => $answers]);
    }


    public function create(): void
    {

        $this->render('answer.create', ['question_id' => $_GET['question_id']]);
    }


    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Method Not Allowed");
        }

        if (!isset($_POST['question_id'], $_POST['message'])) {
            die("Invalid request. Missing fields.");
        }

        $answer = new Answer(
            0,
            (int)$_POST['question_id'],
            $_SESSION['user_id'],
            trim($_POST['message']),
            0
        );

        $this->answerRepository->save($answer);


        header("Location: /question/view?id=" . $_POST['question_id']);
        exit;
    }


    public function editAnswer(): void
    {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            die("Invalid request. Missing answer ID.");
        }

        $id = (int)$_GET['id'];
        $answer = $this->answerRepository->find($id);

        if (!$answer) {
            http_response_code(404);
            die("Answer not found.");
        }

        // Render edit page with answer data
        $this->render('answer.edit', ['answer' => $answer]);
    }

    public function updateAnswer(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Method Not Allowed");
        }

        if (!isset($_POST['id'], $_POST['message'])) {
            die("Invalid request. Missing fields.");
        }

        $id = (int)$_POST['id'];
        $answer = $this->answerRepository->find($id);

        if (!$answer) {
            http_response_code(404);
            die("Answer not found.");
        }

        if ($answer->getIdRegisteredUser() !== $_SESSION['user_id']) {
            http_response_code(403);
            die("Unauthorized action.");
        }

        $answer->setMessage(trim($_POST['message']));

        $this->answerRepository->update($answer);

        header("Location: /question/view?id=" . $_POST['question_id']);
        exit;
    }

    public function deleteAnswer(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Step 1: Show the delete confirmation page
            if (!isset($_GET['id'])) {
                http_response_code(400);
                die("Invalid request. Missing answer ID.");
            }

            $id = (int)$_GET['id'];
            $answer = $this->answerRepository->find($id);

            if (!$answer) {
                http_response_code(404);
                die("Answer not found.");
            }

            if ($answer->getIdRegisteredUser() !== $_SESSION['user_id']) {
                http_response_code(403);
                die("Unauthorized action.");
            }

            $this->render('answer.delete', ['answer' => $answer]);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Step 2: Handle the actual deletion
            if (!isset($_POST['id'], $_POST['question_id'])) {
                http_response_code(400);
                die("Invalid request.");
            }

            $id = (int)$_POST['id'];
            $answer = $this->answerRepository->find($id);

            if (!$answer) {
                http_response_code(404);
                die("Answer not found.");
            }

            if ($answer->getIdRegisteredUser() !== $_SESSION['user_id']) {
                http_response_code(403);
                die("Unauthorized action.");
            }

            $this->answerRepository->delete($id);

            // Redirect back to the question page
            header("Location: /question/view?id=" . $_POST['question_id']);
            exit;
        } else {
            http_response_code(405);
            die("Method Not Allowed");
        }
    }


}