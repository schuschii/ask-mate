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

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirm-password'] ?? '');

        // Basic validation
        if (!$email || !$password || !$confirmPassword) {
            die("All fields are required.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format.");
        }

        if ($password !== $confirmPassword) {
            echo "Passwords do not match.";
        }

        // Create User model and save to the repository
        $user = new User($email, $password);

        try {
            $this->userRepository->save($user);
            header("Location: /home");
            exit;
        } catch (PDOException $e) {
            die("Error saving user: " . $e->getMessage());
        }
    }
}
