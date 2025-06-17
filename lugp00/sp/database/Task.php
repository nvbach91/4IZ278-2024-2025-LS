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
     *
     * @param int    $userId
     * @param string $status  'unclaimed'|'claimed'|'finished'
     * @return array
     */
    public function getByStatus(int $userId, string $status): array {
        $stmt = $this->pdo->prepare(
            'SELECT id, title, description, status
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
     *
     * @param int    $userId
     * @param string $title
     * @param string $description
     * @return int|null  ID nově vloženého úkolu nebo null při chybě
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
            return (int) $this->pdo->lastInsertId();
        }
        return null;
    }

    /**
     * Přiřadí sadu tagů k úkolu.
     *
     * @param int   $taskId
     * @param array $tagIds
     * @return bool  true pokud se vložilo, jinak false
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

    /**
     * Smaže úkol a jeho vazby na tagy.
     *
     * @param int $taskId
     * @return bool
     */
    public function delete(int $taskId): bool {
        try {
            $this->pdo->beginTransaction();
            // smažeme vazby na tagy
            $stmt = $this->pdo->prepare('DELETE FROM task_tags WHERE task_id = :tid');
            $stmt->execute(['tid' => $taskId]);
            // smažeme samotný úkol
            $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = :id');
            $ok = $stmt->execute(['id' => $taskId]);
            $this->pdo->commit();
            return $ok;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    /**
     * Změní status úkolu.
     *
     * @param int    $taskId
     * @param string $status  'unclaimed'|'claimed'|'finished'
     * @return bool
     */
    public function updateStatus(int $taskId, string $status): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE tasks
             SET status = :status, updated_at = NOW()
             WHERE id = :id'
        );
        return $stmt->execute([
            'status' => $status,
            'id'     => $taskId
        ]);
    }

    /**
     * Aktualizuje údaje úkolu (titulek a popis).
     *
     * @param int    $taskId
     * @param string $title
     * @param string $description
     * @return bool
     */
    public function update(int $taskId, string $title, string $description): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE tasks
             SET title = :title,
                 description = :description,
                 updated_at = NOW()
             WHERE id = :id'
        );
        return $stmt->execute([
            'title'       => $title,
            'description' => $description,
            'id'          => $taskId
        ]);
    }
}
