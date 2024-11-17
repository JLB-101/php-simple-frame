<?php

namespace app\Controllers;

use App\Models\User;

class AuthController
{
    public function __construct()
    {
        session_start();
    }

    // Tela de login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = User::findByEmail($email);

            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                header('Location: /dashboard');
                exit();
            } else {
                echo "Credenciais inválidas.";
            }
        }

        include __DIR__ . '/../Views/auth/login.php';
    }

    // Tela de registro
    public function register()
    {
        include __DIR__ . '/../Views/auth/register.php';
    }

    // Verificação de autenticação
    public function checkAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    // Logout
    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit();
    }
}
