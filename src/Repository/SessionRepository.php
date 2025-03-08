<?php

namespace Mugiew\Galeano\Repository;

use Mugiew\Galeano\Domain\Session;

class SessionRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session): Session
    {
        $stmt = $this->connection->prepare('INSERT INTO sessions(id, user_id) VALUES (?, ?)');
        $stmt->execute([$session->id, $session->userId]);

        return $session;
    }

    public function findById(string $id): ?Session
    {
        $stmt = $this->connection->prepare('SELECT * FROM sessions WHERE id = ?');
        $stmt->execute([$id]);

        try {
            if ($row = $stmt->fetch()) {
                $session = new Session();
                $session->id = $row['id'];
                $session->userId = $row['user_id'];
                return $session;
            } else {
                return null;
            }
        } finally {
            $stmt->closeCursor();
        }
    }

    public function deleteById(string $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM sessions WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->connection->exec('DELETE FROM sessions');
    }
}
