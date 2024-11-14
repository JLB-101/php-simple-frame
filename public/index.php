<?php

require_once __DIR__ . '/../vendor/autoload.php';

$router = new piecing\routing\Route();
// esperado que  routes file retorne callable
// or else this code would break

$routes = require_once(__DIR__ . '/../app/routes.php');
$routes($router);

print($router->dispatch());