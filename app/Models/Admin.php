<?php 
namespace app\Models;

use app\Database\Connection;

use app\Models\UserManager;

class Admin extends UserManager
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;
    private $active;
    private $created_at;
    private $updated_at;

    // Construtor
    public function __construct($name = null, $email = null, $password = null, $role = $role )
    {
        // O Role 0 é para Admin
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->active = 1; // Administrador ativo por padrão
    }

    // Getters e Setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * Cria um novo administrador no banco de dados.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return int ID do administrador criado.
     */
    public function createAdmin(): int
    {
        $query = "INSERT INTO users (name, email, password, role, active) VALUES (?, ?, ?, ?, ?)";
        $params = [$this->name, $this->email, password_hash($this->password, PASSWORD_DEFAULT), $this->role, $this->active];
        return Connection::execute($query, $params);
    }

    /**
     * Atualiza os dados de um administrador.
     *
     * @return int Número de linhas afetadas.
     */
    public function updateAdmin(): int
    {
        $query = "UPDATE users SET name = ?, email = ?, password = ?, active = ? WHERE id = ?";
        $params = [$this->name, $this->email, password_hash($this->password, PASSWORD_DEFAULT), $this->active, $this->id];
        return Connection::execute($query, $params);
    }

    /**
     * Exclui um administrador do banco de dados.
     *
     * @param string $email
     * @return int Número de linhas afetadas.
     */
    public static function deleteAdminByEmail(string $email): int
    {
        return Connection::execute("DELETE FROM users WHERE email = ? AND role = 0", [$email]); // Deleta o administrador pelo e-mail
    }

    /**
     * Retorna todos os administradores.
     *
     * @return array
     */
    public static function getAllAdmins(): array
    {
        return Connection::select("SELECT * FROM users WHERE role = 0"); // Administradores (role = 0)
    }

    /**
     * Busca um administrador pelo e-mail.
     *
     * @param string $email
     * @return Admin|null
     */
    public static function findAdminByEmail(string $email): ?self
    {
        return User::findItem('email', $email); // Utiliza o método findItem para buscar o admin
    }

}
