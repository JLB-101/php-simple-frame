<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = User::findByEmail($email);

            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                header('Location: /');
                exit();
            } else {
                echo "Credenciais inválidas.";
            }
        }

        include __DIR__ . '/../Views/auth/login.php';
    }

    public function register()
    {
        include __DIR__ . '/../Views/auth/register.php';
    }

    public function checkAuth()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }
}
