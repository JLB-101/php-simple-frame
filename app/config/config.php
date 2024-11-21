<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

// Carregar variáveis do arquivo .env
$dotenv = Dotenv::createImmutable(dirname(__DIR__.'/../../.env'));
$dotenv->load();



return [
    // Configuração do banco de dados
    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'dbname' => getenv('DB_NAME') ?: 'peing_db',
        'user' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: 'nova_senha',
        'port' => getenv('DB_PORT') ?: 3306,
    ],

    // Configuração de sessão
    'session' => [
        'timeout' => 28800, // 8 horas
        'secure' => false, // Alterar para 'true' em produção (requer HTTPS)
        'httponly' => true, // Impede o acesso aos cookies via JavaScript
        'samesite' => 'Strict', // Proteção contra CSRF (usar 'Lax' se necessário)
    ],

    // Configuração de ambiente
    'environment' => getenv('APP_ENV') ?: 'development', // Alterar para 'production' em produção

    // Outras configurações globais podem ser adicionadas aqui no futuro
];
