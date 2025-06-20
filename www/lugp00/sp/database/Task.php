<?php
// sp/database/Task.php
namespace App;

use PDO;
use PDOException;

class Task {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Vrátí všechny úkoly daného uživatele podle statusu.
     */
    public function getByStatus(int $userId, string $status): array {
        $stmt = $this->pdo->prepare(
            'SELECT id, title, description, status, created_at, updated_at
             FROM tasks
             WHERE user_id = :uid AND status = :status
             ORDER BY created_at DESC'
        );
        $stmt->execute([
            'uid'    => $userId,
            'status' => $status
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Vytvoří nový úkol (status se nastaví na 'unclaimed').
     * @return int|null ID nově vloženého úkolu.
     */
    public function create(int $userId, string $title, string $description): ?int {
        $stmt = $this->pdo->prepare(
            'INSERT INTO tasks (user_id, title, description, status, created_at, updated_at) 
             VALUES (:uid, :title, :desc, \'unclaimed\', NOW(), NOW())'
        );
        $ok = $stmt->execute([
            'uid'   => $userId,
            'title' => $title,
            'desc'  => $description
        ]);
        if ($ok) {
            return (int)$this->pdo->lastInsertId();
        }
        return null;
    }

    /**
     * Aktualizuje titulek a popis úkolu.
     */
    public function update(int $taskId, string $title, string $description): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE tasks
             SET title = :title,
                 description = :desc,
                 updated_at = NOW()
             WHERE id = :id'
        );
        return $stmt->execute([
            'title' => $title,
            'desc'  => $description,
            'id'    => $taskId
        ]);
    }

    /**
     * Aktualizuje stav úkolu a aktualizuje updated_at.
     */
    public function updateStatus(int $taskId, string $status): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE tasks
             SET status = :status,
                 updated_at = NOW()
             WHERE id = :id'
        );
        return $stmt->execute([
            'status' => $status,
            'id'     => $taskId
        ]);
    }

    /**
     * Smaže úkol a všechny jeho tagy a sdílení.
     */
    public function delete(int $taskId): bool {
        try {
            $this->pdo->beginTransaction();
            $this->pdo->prepare('DELETE FROM task_tags WHERE task_id = :tid')
                      ->execute(['tid' => $taskId]);
            $this->pdo->prepare('DELETE FROM task_shares WHERE task_id = :tid')
                      ->execute(['tid' => $taskId]);
            $this->pdo->prepare('DELETE FROM tasks WHERE id = :id')
                      ->execute(['id' => $taskId]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    /**
     * Přiřadí sadu tagů k úkolu.
     * Vrátí true, pokud se vše vložilo, jinak false.
     */
    public function assignTags(int $taskId, array $tagIds): bool {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare(
                'INSERT INTO task_tags (task_id, tag_id) VALUES (:task_id, :tag_id)'
            );
            foreach ($tagIds as $tagId) {
                $stmt->execute([
                    'task_id' => $taskId,
                    'tag_id'  => $tagId
                ]);
            }
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
