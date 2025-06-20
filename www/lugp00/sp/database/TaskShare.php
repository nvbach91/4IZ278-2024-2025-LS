<?php
// sp/database/TaskShare.php

namespace App;

use PDO;
use PDOException;

class TaskShare {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Vrátí všechny uživatele s přístupem k úkolu (stav = 'pending' nebo 'accepted').
     *
     * @param int $taskId
     * @return array  Pole s klíči [share_id, user_id, name, email, status]
     */
    public function getSharedUsers(int $taskId): array {
        $stmt = $this->pdo->prepare(
            'SELECT 
                ts.id             AS share_id,
                u.id              AS user_id,
                u.name            AS name,
                u.email           AS email,
                ts.status         AS status
             FROM task_shares ts
             JOIN users u 
               ON ts.shared_with_user_id = u.id
             WHERE ts.task_id = :tid
               AND ts.status IN (\'pending\',\'accepted\')
             ORDER BY ts.created_at DESC'
        );
        $stmt->execute(['tid' => $taskId]);
        return $stmt->fetchAll();
    }

    /**
     * Přidá nebo obnoví pozvánku ke sdílení úkolu (status = 'pending').
     * Nelze sdílet sám se sebou.
     * Pokud už existuje 'pending' či 'accepted', vrátí true.
     * Pokud je 'declined', obnoví jej na 'pending'.
     *
     * @param int    $taskId
     * @param string $email
     * @param int    $sharedByUserId
     * @return bool
     */
    public function shareByEmail(int $taskId, string $email, int $sharedByUserId): bool {
        // 1) cílový uživatel
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        if (!$row) return false;
        $sharedWith = (int)$row['id'];

        // 2) nelze pozvat sám sebe
        if ($sharedWith === $sharedByUserId) return false;

        // 3) existující záznam?
        $stmt = $this->pdo->prepare(
            'SELECT id, status
             FROM task_shares
             WHERE task_id = :tid AND shared_with_user_id = :uid'
        );
        $stmt->execute(['tid' => $taskId, 'uid' => $sharedWith]);
        $existing = $stmt->fetch();

        if ($existing) {
            // už je pending nebo accepted
            if (in_array($existing['status'], ['pending','accepted'], true)) {
                return true;
            }
            // byl declined, obnovíme na pending
            $upd = $this->pdo->prepare(
                'UPDATE task_shares
                 SET status = \'pending\', shared_by_user_id = :by, updated_at = NOW()
                 WHERE id = :sid'
            );
            return $upd->execute([
                'by'  => $sharedByUserId,
                'sid' => $existing['id']
            ]);
        }

        // 4) vložíme novou pozvánku
        $ins = $this->pdo->prepare(
            'INSERT INTO task_shares
                (task_id, shared_with_user_id, shared_by_user_id, status, created_at, updated_at)
             VALUES
                (:tid, :with, :by, \'pending\', NOW(), NOW())'
        );
        try {
            return $ins->execute([
                'tid'  => $taskId,
                'with' => $sharedWith,
                'by'   => $sharedByUserId
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Přijme pozvánku (změní status na 'accepted').
     *
     * @param int $shareId
     * @return bool
     */
    public function accept(int $shareId): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE task_shares
             SET status = \'accepted\', updated_at = NOW()
             WHERE id = :sid'
        );
        return $stmt->execute(['sid' => $shareId]);
    }

    /**
     * Odmítne pozvánku (změní status na 'declined').
     *
     * @param int $shareId
     * @return bool
     */
    public function decline(int $shareId): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE task_shares
             SET status = \'declined\', updated_at = NOW()
             WHERE id = :sid'
        );
        return $stmt->execute(['sid' => $shareId]);
    }

    /**
     * Zruší jakoukoli pozvánku či přístup (všechny statusy) uživatele k úkolu.
     *
     * @param int $taskId
     * @param int $userId
     * @return bool
     */
    public function unshare(int $taskId, int $userId): bool {
        $stmt = $this->pdo->prepare(
            'DELETE FROM task_shares
             WHERE task_id = :tid AND shared_with_user_id = :uid'
        );
        return $stmt->execute([
            'tid' => $taskId,
            'uid' => $userId
        ]);
    }

    /**
     * Vrátí všechny nevyřízené pozvánky (status = 'pending') pro uživatele.
     *
     * @param int $userId
     * @return array
     */
    public function getPendingForUser(int $userId): array {
        $stmt = $this->pdo->prepare(
            'SELECT 
                ts.id        AS share_id,
                t.id         AS task_id,
                t.title      AS title,
                u.name       AS shared_by_name,
                u.email      AS shared_by_email,
                ts.created_at
             FROM task_shares ts
             JOIN tasks t ON ts.task_id = t.id
             JOIN users u ON ts.shared_by_user_id = u.id
             WHERE ts.shared_with_user_id = :uid
               AND ts.status = \'pending\'
             ORDER BY ts.created_at DESC'
        );
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }
}
