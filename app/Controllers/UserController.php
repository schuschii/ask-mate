<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

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

    public function loginUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Method Not Allowed");
        }

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$email || !$password) {
            echo "All fields are required.";
        }

        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            echo "User not found. Try again.";
        }

        if (!$this->userRepository->isPasswordValid($email, $password)) {
            echo("Invalid password.");
        } else {
            echo "GOOD PASSWORD";
        }


        // Password is valid; set session and redirect
        $_SESSION['user'] = $user->id;
        header("Location: /home");
        exit;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
        header("Location: /home");
        exit;
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

        // Check if the email already exists in the database
        $existingUser = $this->userRepository->findByEmail($email);
        if ($existingUser) {
            die("This email is already registered. Please use a different email.");
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
        } catch (Exception $e) {
            die("Error saving user: " . $e->getMessage());
        }
    }
}
