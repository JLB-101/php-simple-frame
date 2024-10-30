<?php

namespace App\Models;

use PDO;

class User
{
    public $id;
    public $email;
    public $password;

    public static function findByEmail($email)
    {
        $config = include __DIR__ . '/../../config/config.php';
        $pdo = new PDO(
            "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
            $config['db']['user'],
            $config['db']['password']
        );

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }
}
