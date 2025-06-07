<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/User.php';

class UserController extends BaseController
{
    public function register()
    {
        $data = [
            'pageTitle' => 'Register',
            'error' => '',
            'success' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // input validations
            if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
                $data['error'] = 'All fields are required.';
            } elseif ($password !== $confirmPassword) {
                $data['error'] = 'Passwords do not match.';
            } elseif (strlen($password) < 6) {
                $data['error'] = 'Password must be at least 6 characters long.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Please enter a valid email address.';
            } else {
                // if all ok, register
                $user = new User();
                if ($user->register($username, $email, $password)) {
                    $data['success'] = 'Account created successfully! You can now log in.';
                } else {
                    $data['error'] = 'Username or email already exists. Please try again.';
                }
            }
        }

        $this->render('register', $data);
    }
    public function login()
    {
        $data = [
            'pageTitle' => 'Login',
            'error' => '',
            'success' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // validation
            if (empty($email) || empty($password)) {
                $data['error'] = 'Email and password are required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Please enter a valid email address.';
            } else {
                $user = new User();
                $loginResult = $user->login($email, $password);
                if ($loginResult) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['username'] = $user->username;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['role'] = $loginResult['role'];
                    $_SESSION['logged_in'] = true;

                    // redirect to home page
                    header('Location: ./');
                    exit();
                } else {
                    $data['error'] = 'Invalid email or password.';
                }
            }
        }

        $this->render('login', $data);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ./');
        exit();
    }
}
