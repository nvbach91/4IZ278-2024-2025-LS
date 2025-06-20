<?php
// sp/database/Tag.php
namespace App;

use PDO;
use PDOException;

class Tag {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Načte všechny tagy daného uživatele.
     * @return array
     */
    public function getAll(int $userId): array {
        $stmt = $this->pdo->prepare(
            'SELECT id, name, color 
             FROM tags 
             WHERE user_id = :uid 
             ORDER BY name'
        );
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Vytvoří nový tag.
     */
    public function create(int $userId, string $name, string $color): bool {
        $stmt = $this->pdo->prepare(
            'INSERT INTO tags (user_id, name, color) 
             VALUES (:uid, :name, :color)'
        );
        return $stmt->execute([
            'uid'   => $userId,
            'name'  => $name,
            'color' => $color
        ]);
    }

    /**
     * Upravení existujícího tagu.
     */
    public function update(int $tagId, string $name, string $color): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE tags 
             SET name = :name, color = :color 
             WHERE id = :id'
        );
        return $stmt->execute([
            'id'    => $tagId,
            'name'  => $name,
            'color' => $color
        ]);
    }

    /**
     * Smaže tag.
     */
    public function delete(int $tagId): bool {
        $stmt = $this->pdo->prepare(
            'DELETE FROM tags 
             WHERE id = :id'
        );
        return $stmt->execute(['id' => $tagId]);
    }


    /**
     * Načte tagy přiřazené ke konkrétnímu úkolu.
     *
     * @param int $taskId
     * @return array  Pole ['id','name','color']
     */
    public function getByTask(int $taskId): array {
        $stmt = $this->pdo->prepare(
            'SELECT tg.id, tg.name, tg.color
             FROM tags tg
             JOIN task_tags tt ON tt.tag_id = tg.id
             WHERE tt.task_id = :tid
             ORDER BY tg.name'
        );
        $stmt->execute(['tid' => $taskId]);
        return $stmt->fetchAll();
    }

}
