<?php


namespace app\Models;
use app\Database\Connection;
use app\Models\User;

class UserManager
{
    /**
     * Cria um novo usuário no banco de dados.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return int ID do usuário criado.
     */
    public function createUser(string $name, string $email, string $password): int
    {
        $user = new User($name, $email, $password);
        return $user->create(); // Cria o usuário no banco
    }

    /**
     * Busca um usuário pelo e-mail.
     *
     * @param string $email
     * @return User|null
     */
    public static function findUserByEmail(string $email): ?User
    {
        return User::findItem('email', $email); // Utiliza o método findItem para buscar pelo e-mail
    }

    /**
     * Atualiza os dados de um usuário.
     *
     * @param User $user
     * @return int Número de linhas afetadas.
     */
    public function updateUser(User $user): int
    {
        return $user->update(); // Atualiza os dados do usuário
    }

    /**
     * Exclui um usuário do banco de dados.
     *
     * @param string $email
     * @return int Número de linhas afetadas.
     */
    public static function deleteUserByEmail(string $email): int
    {
        return Connection::execute("DELETE FROM users WHERE email = ?", [$email]); // Deleta o usuário pelo e-mail
    }

    /**
     * Retorna todos os usuários ativos.
     *
     * @return array
     */
    public static function getActiveUsers(): array
    {
        return Connection::select("SELECT * FROM users WHERE role = 1 AND active = ?", [1]); // Usuários normais (role = 1)
    }
}
