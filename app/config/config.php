<?php
return [
    // Configuração do banco de dados
    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost', 
        'dbname' => getenv('DB_NAME') ?: 'peing_db',
        'user' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: 'root',
    ],

    // Configuração de sessão
    'session' => [
        'timeout' => 3600, // 1 hora
        'secure' => false, // Alterar para 'true' em produção (requer HTTPS)
        'httponly' => true, // Impede o acesso aos cookies via JavaScript
        'samesite' => 'Strict', // Proteção contra CSRF (usar 'Lax' se necessário)
    ],

    // Configuração de ambiente
    'environment' => getenv('APP_ENV') ?: 'development', // Alterar para 'production' em produção

    // Outras configurações globais podem ser adicionadas aqui no futuro
];
