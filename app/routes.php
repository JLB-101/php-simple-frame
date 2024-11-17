<?php

use app\Controllers\AuthController;
use app\Controllers\PageController;
use piecing\routing\Router;

return function (Router $router) {
    // Instâncias dos controladores
    $pageController = new PageController();
    $authController = new AuthController();
    // Rotas públicas
    // Página inicial
    $router->add('GET', '/', fn() =>  $pageController->home());
    // Página "Sobre"
    $router->add('GET', '/about', fn() => $pageController->about());
    // Página de Contato
    $router->add('GET', '/contact', fn() => $pageController->contact());

    // Rotas de autenticação
    // Exibe o formulário de login (GET) e processa o login (POST)
    $router->add('GET', '/login', fn() => $authController->login());
    $router->add('POST', '/login', fn() => $authController->login());
    // Página de registro
    $router->add('GET', '/register', fn() => $authController->register());
    // Logout
    $router->add('GET', '/logout', fn() => $authController->logout());

    // Rotas privadas
    // Página do Dashboard
    $router->add('GET', '/dashboard', function () use ($authController, $pageController) {
        $authController->checkAuth(); // Verifica autenticação
        include __DIR__ . '/../Views/private/dashboard.php'; // Renderiza o dashboard
    });

    // Página não encontrada
    $router->errorHandler(404, fn() => $pageController->pageNotFound());
};
