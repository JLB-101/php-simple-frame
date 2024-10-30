<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\PageController;
use App\Controllers\AuthController;

// Definir a página inicial e configurar as rotas
$uri = $_SERVER['REQUEST_URI'];

switch ($uri) {
    case '/':
        (new PageController())->home();
        break;
    case '/about':
        (new PageController())->about();
        break;
    case '/contact':
        (new PageController())->contact();
        break;
    case '/login':
        (new AuthController())->login();
        break;
    case '/register':
        (new AuthController())->register();
        break;
    default:
        echo "Página não encontrada";
        break;
}
