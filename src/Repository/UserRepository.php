<?php

namespace Mugiew\Galeano\Repository;

use Mugiew\Galeano\Domain\User;

class UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function login(User $user): User
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
        $stmt->execute([
            'username' => $user->username,
            'password' => $user->password
        ]);

        $user = $stmt->fetchObject(User::class);
        return $user;
    }

    public function register(User $user): User
    {
        $stmt = $this->connection->prepare('INSERT INTO users (id, username, password) VALUES (:id, :username, :password)');
        $stmt->execute([
            'id' => $user->id,
            'username' => $user->username,
            'password' => $user->password
        ]);

        return $user;
    }

    public function findById(string $id): ?User
    {
        $stmt = $this->connection->prepare('SELECT id, username, password FROM users WHERE id = :id');
        $stmt->execute([
            'id' => $id
        ]);

        try {
            if ($row = $stmt->fetch()) {
                $user = new User();
                $user->id = $row['id'];
                $user->username = $row['username'];
                $user->password = $row['password'];
                return $user;
            } else {
                return null;
            }
        } finally {
            $stmt->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->connection->exec('DELETE FROM users');
    }
}
