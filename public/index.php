<?php

use piecing\routing\Router;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../routing/Router.php';
require_once __DIR__ . '/../routing/Route.php';

$router = new Router();

// Carregar as rotas
$routes = require_once(__DIR__ . '/../app/routes.php');
$routes($router);

// Executar o roteamento e exibir a saída
print($router->dispatch());
