<?php

namespace app\Controllers;

use app\Models\User;

class AuthController
{
    public function __construct()
    {
        session_start();
        // Gera um token CSRF se não existir
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    // Tela de login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Proteção contra CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("CSRF token inválido.");
            }

            // Sanitizar entrada
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED);
            

             // Busca o usuário
            $user = User::findByEmail($email);

            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                header('Location: /dashboard');
                exit();
            } else {
                $_SESSION['error'] = "Credenciais inválidas.";
                header('Location: /login');
                exit();
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
            $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
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
