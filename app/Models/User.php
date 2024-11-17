<?php

namespace App\Models;

use PDO;
use PDOException;
use InvalidArgumentException;
use RuntimeException;

class User
{
    public $id;
    public $email;
    public $password;

    public static function findByEmail($email)
    {
        // Validação do formato do e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Formato de e-mail inválido.");
        }

        // Carregando configurações do banco
        $config = include __DIR__ . '/../../config/config.php';

        try {
            // Criando conexão com o banco de dados com configurações seguras
            $pdo = new PDO(
                "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']};charset=utf8mb4",
                $config['db']['user'],
                $config['db']['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            // Log do erro sem expor informações sensíveis
            error_log("Erro de conexão: " . $e->getMessage());
            throw new RuntimeException("Não foi possível conectar ao banco de dados.");
        }

        // Consulta preparada para buscar usuário por e-mail
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro na execução da consulta: " . $e->getMessage());
            throw new RuntimeException("Erro ao buscar usuário no banco de dados.");
        }
    }
}
