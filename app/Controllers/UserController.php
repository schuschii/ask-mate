<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Model\User;
use App\Repositories\UserRepository;
class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login(): void
    {
        $this->render('auth.login');
    }

    public function createUser(): void
    {
        $this->render('auth.signup');;
    }

    public function saveUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Method Not Allowed");
        }

        if (!isset($_POST['email'], $_POST['password'])) {
            die("Invalid request. Missing fields.");
        }

        $user = new User($_POST['email'], $_POST['password']);
        $this->userRepository->save($user);

        header("Location: /home");
        exit;
    }
}
