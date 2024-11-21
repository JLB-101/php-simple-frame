<?php

namespace app\Database;

use PDO;
use PDOException;

class Connection
{
    private static $instance = null;
    private static $config; // Configurações carregadas no início

    /**
     * Carrega as configurações uma única vez.
     */
    private static function loadConfig(): void
    {
        if (!self::$config) {
            self::$config = require __DIR__ . '/../config/config.php';
        }
    }

    /**
     * Inicializa o banco de dados e as tabelas, caso não existam.
     */
    private static function initializeDatabase(PDO $pdo): void
    {
        $dbName = self::$config['db']['dbname'];

        // Criação do banco de dados (se não existir)
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        // Selecionar o banco de dados criado
        $pdo->exec("USE `$dbName`");

        // Criação da tabela de usuários (se não existir)
        $createUsersTable = <<<SQL
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL, -- Senha em hash
            status BOOLEAN NOT NULL DEFAULT TRUE,
            role TINYINT NOT NULL DEFAULT 1, -- 0 para superuser, 1 para usuário comum
            contact VARCHAR(15),
            location VARCHAR(255),
            access_key VARCHAR(255) NOT NULL UNIQUE, -- Chave de acesso única
            last_access DATETIME NULL, -- Último acesso
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );
        SQL;

        $pdo->exec($createUsersTable);
    }

    /**
     * Retorna a instância única do PDO.
     */
    public static function getInstance(): PDO
    {
        self::loadConfig(); // Garante que as configurações estejam carregadas

        if (!self::$instance) {
            $dbConfig = self::$config['db'];

            try {
                // Conectar sem selecionar banco, para garantir a criação do mesmo
                self::$instance = new PDO(
                    "mysql:host={$dbConfig['host']};port={$dbConfig['port']}",
                    $dbConfig['user'],
                    $dbConfig['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );

                // Inicializar banco de dados e tabelas
                self::initializeDatabase(self::$instance);

            } catch (PDOException $e) {
                die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Executa uma consulta SQL e retorna todos os resultados.
     */
    public static function select(string $query, array $params = []): array
    {
        $pdo = self::getInstance();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Executa uma consulta SQL e retorna a primeira linha.
     */
    public static function selectOne(string $query, array $params = []): ?array
    {
        $pdo = self::getInstance();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch() ?: null;
    }

    /**
     * Executa uma consulta SQL de manipulação (INSERT, UPDATE, DELETE).
     */
    public static function execute(string $query, array $params = []): int
    {
        $pdo = self::getInstance();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Insere um novo usuário no banco de dados.
     */
    public static function createUser(string $username, string $email, string $password, int $role = 1, string $contact = null, string $location = null): int
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash da senha
        $accessKey = bin2hex(random_bytes(16)); // Gera uma chave de acesso única

        $query = "
            INSERT INTO users (username, email, password, role, contact, location, access_key)
            VALUES (:username, :email, :password, :role, :contact, :location, :access_key)
        ";

        return self::execute($query, [
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':role' => $role,
            ':contact' => $contact,
            ':location' => $location,
            ':access_key' => $accessKey,
        ]);
    }

    /**
     * Atualiza o campo `last_access` para o horário atual.
     */
    public static function updateLastAccess(int $userId): void
    {
        $query = "UPDATE users SET last_access = NOW() WHERE id = :id";
        self::execute($query, [':id' => $userId]);
    }
}
