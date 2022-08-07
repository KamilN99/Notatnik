<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\NotFoundExcetion;
use App\Exception\StorageException;
use PDO;
use Throwable;

class NoteModel extends AbstractModel
{
    //create
    public function create(array $data): void
    {
        try {
            $title = $this->connection->quote($data['title']);
            $description = $this->connection->quote($data['description']);
            $created = $this->connection->quote(date('Y-m-d H:i:s'));
            $userId = (int) $data['userId'];

            $stmt = "INSERT INTO notes(title, description, created, user_id) 
            VALUES($title, $description, $created, $userId)";
            $this->connection->exec($stmt);
        } catch (Throwable $e) {
            throw new StorageException("Błąd zapisu do bazy", 400, $e);
        }
    }

    //read
    public function get(int $id): array
    {
        try {
            $stmt = "SELECT * FROM notes WHERE id=$id";
            $result = $this->connection->query($stmt);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatki', 400, $e);
        }
        if (!$note) {
            throw new NotFoundExcetion("Notatka o id: $id nie istnieje");
        }
        return $note;
    }

    public function list(int $pageNumber, int $pageSize, string $sortBy, string $sortOrder, int $userId): array
    {
        return $this->findBy(null, $pageNumber, $pageSize, $sortBy, $sortOrder, $userId);
    }

    public function search(string $phrase, int $pageNumber, int $pageSize, string $sortBy, string $sortOrder, int $userId): array
    {
        return $this->findBy($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder, $userId);
    }

    public function count(int $userID): int
    {
        try {
            $stmt = "SELECT count(*) AS notesCount FROM notes WHERE user_id=$userID";
            $result = $this->connection->query($stmt);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            return (int) $result['notesCount'];
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać liczby notatek', 400, $e);
        }
    }

    public function searchCount(int $userID, string $phrase): int
    {
        try {
            $phrase = $this->connection->quote('%' . $phrase . '%');
            $stmt = "SELECT count(*) AS notesCount FROM notes WHERE user_id=$userID AND title LIKE $phrase";
            $result = $this->connection->query($stmt);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            return (int) $result['notesCount'];
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać liczby notatek', 400, $e);
        }
    }

    //update
    public function edit(int $id, array $data): void
    {
        try {
            $title = $this->connection->quote($data['title']);
            $description = $this->connection->quote($data['description']);
            $stmt = "UPDATE notes SET title=$title, description=$description
            WHERE id=$id";

            $this->connection->exec($stmt);
        } catch (Throwable $e) {
            throw new StorageException("Błąd aktualizacji bazy", 400, $e);
        }
    }

    //delete
    public function delete(int $id): void
    {
        try {
            $stmt = "DELETE FROM notes WHERE id=$id";
            $this->connection->exec($stmt);
        } catch (Throwable $e) {
            throw new StorageException("Błąd usuwania notatki", 400, $e);
        }
    }

    //private methods
    private function findBy(?string $phrase, int $pageNumber, int $pageSize, string $sortBy, string $sortOrder, int $userId): array
    {
        try {
            $offset = ($pageNumber - 1) * $pageSize;

            if (!in_array($sortBy, ['title', 'created'])) {
                $sortBy = 'title';
            }
            if (!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'desc';
            }

            if ($phrase) {
                $phrase = $this->connection->quote('%' . $phrase . '%');
                $phrase = "AND title LIKE $phrase";
            }

            $stmt = "SELECT id, title, created 
            FROM notes 
            WHERE user_id=$userId $phrase 
            ORDER BY $sortBy $sortOrder
            LIMIT $offset, $pageSize";

            $result = $this->connection->query($stmt);
            $notes = $result->fetchAll(PDO::FETCH_ASSOC);
            return $notes;
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatek', 400, $e);
        }
    }
}
