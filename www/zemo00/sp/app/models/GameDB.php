<?php

require_once __DIR__ . "/../core/Model.php";

class GameDB extends Model {
    
    protected string $tableName = 'sp_games';
    protected string|array $primaryKey = 'game_id';

    /**
     * Fetches game statistics for a specific user.
     * 
     * @param string|int $user_id The ID of the user.
     * @return array Associative array with game data.
     */
    public function fetchStats(string|int $user_id): array {
        $sqlGames = "SELECT COUNT(*)
                        FROM $this->tableName
                        WHERE user_id = ?";
        $statement1 = $this->db->prepare($sqlGames);
        $statement1->execute([$user_id]);
        $gamesPlayed = (int) $statement1->fetchColumn();

        $sqlAnswers = "SELECT
                            SUM(CASE WHEN gw.correct = 1 THEN 1 ELSE 0 END) AS correct,
                            SUM(CASE WHEN gw.correct = 0 THEN 1 ELSE 0 END) AS incorrect
                        FROM sp_game_words gw
                        INNER JOIN $this->tableName g
                            ON gw.game_id = g.game_id
                        WHERE g.user_id = ?";
        $statement2 = $this->db->prepare($sqlAnswers);
        $statement2->execute([$user_id]);
        $result = $statement2->fetch(PDO::FETCH_ASSOC);

        $correct = (int) ($result['correct'] ?? 0);
        $incorrect = (int) ($result['incorrect'] ?? 0);
        $total = $correct + $incorrect;
        $rate = $total > 0 ? round(($correct / $total) * 100) : 0;

        return [
            'games_played' => $gamesPlayed,
            'correct' => $correct,
            'incorrect' => $incorrect,
            'success_rate' => $rate
        ];
    }

}

?>