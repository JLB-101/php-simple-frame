<?php
# Imports:
use Dotenv\Dotenv;
use piecing\routing\Router;
// use app\Controllers\PageController;

require_once __DIR__ . '/../vendor/autoload.php';

// este diretamente o carregamento da classe: true
// var_dump(class_exists('piecing\routing\Router'));

// $config = require __DIR__ . '/../app/config/config.php';
// var_dump($config);



// exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carregar variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Instância do roteador
$router = new Router();

// Carregar as rotas
$routes = require_once(__DIR__ . '/../app/routes.php');
$routes($router);

// Executar o roteador
echo $router->dispatch();
