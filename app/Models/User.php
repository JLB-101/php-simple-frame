<?php

namespace app\Models;

use app\Database\Connection;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;
    private $active;
    private $created_at;
    private $updated_at;

    public function __construct($name = null, $email = null, $password = null, $role = 1)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->active = 1; // Usuário ativo por padrão
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
     * Cria um novo usuário no banco de dados.
     *
     * @return int ID do usuário criado.
     */
    public function create(): int
    {
        $query = "INSERT INTO users (name, email, password, role, active) VALUES (?, ?, ?, ?, ?)";
        $params = [$this->name, $this->email, password_hash($this->password, PASSWORD_DEFAULT), $this->role, $this->active];
        return Connection::execute($query, $params);
    }

    /**
     * Atualiza os dados de um usuário no banco de dados.
     *
     * @return int Número de linhas afetadas.
     */
    public function update(): int
    {
        $query = "UPDATE users SET name = ?, email = ?, password = ?, active = ? WHERE id = ?";
        $params = [$this->name, $this->email, password_hash($this->password, PASSWORD_DEFAULT), $this->active, $this->id];
        return Connection::execute($query, $params);
    }

    /**
     * Busca um item no banco de dados.
     * Pode ser utilizado para buscar usuários por qualquer campo.
     *
     * @param string $column
     * @param mixed $value
     * @return User|null
     */
    public static function findItem($column, $value): ?self
    {
        $query = "SELECT * FROM users WHERE $column = ?";
        $result = Connection::selectOne($query, [$value]);

        if ($result) {
            $user = new self();
            $user->setId($result['id']);
            $user->setName($result['name']);
            $user->setEmail($result['email']);
            $user->setPassword($result['password']);
            $user->setRole($result['role']);
            $user->setActive($result['active']);
            $user->setCreatedAt($result['created_at']);
            $user->setUpdatedAt($result['updated_at']);
            return $user;
        }

        return null;
    }
}
