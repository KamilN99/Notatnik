<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\StorageException;
use PDO;
use Throwable;

class UserModel extends AbstractModel
{
    //create
    public function create(array $data): void
    {
        try {
            $login = $this->connection->quote($data['login']);
            $password = $this->connection->quote($data['password']);

            $stmt = "INSERT INTO users (login, password) 
            VALUES($login, $password)";
            $this->connection->exec($stmt);
        } catch (Throwable $e) {
            throw new StorageException("Błąd zapisu do bazy", 400, $e);
        }
    }

    //read
    public function get(string $login, string $password): ?int
    {
        try {
            $login = $this->connection->quote($login);
            $password = $this->connection->quote($password);

            $stmt = "SELECT id FROM users WHERE login=$login AND password=$password";
            $result = $this->connection->query($stmt);
            $result = $result->fetch(PDO::FETCH_ASSOC);

        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać informacji', 400, $e);
        }
        return $result['id'] ?? null;
    }
}