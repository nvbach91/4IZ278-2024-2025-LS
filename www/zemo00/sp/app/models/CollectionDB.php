<?php

require_once __DIR__ . "/../core/Model.php";

class CollectionDB extends Model {
    
    protected string $tableName = 'sp_collections';
    protected string|array $primaryKey = 'collection_id';
    public ?array $sortingColumns = ['collection_id'];

    /**
     * Fetches all collections of one user.
     * 
     * @param string|int $user_id The id of the user.
     * @return array The fetched collections.
     */
    function fetchCollections(string|int $user_id): array {
        $sql = "SELECT c.collection_id, c.name, c.created_at, COUNT(*) as amount
                    FROM $this->tableName c
                    LEFT JOIN sp_collection_words cw
                        ON cw.collection_id = c.collection_id
                    WHERE c.user_id = ?
                    GROUP BY c.collection_id, c.name, c.created_at;";
        $statement = $this->db->prepare($sql);
        $statement->execute([$user_id]);

        return $statement->fetchAll();
    }

    /**
     * Fetches all user's collections, but only those that contain words of a specific language.
     * 
     * @param string|int $user_id The id of the user.
     * @param string $lang_code The code of the language.
     */
    public function fetchFilteredCollections(string|int $user_id, string $lang_code): array {
        $sql = "SELECT c.collection_id, c.name, c.created_at, COUNT(*) as amount
                    FROM sp_collection_words cw
                    INNER JOIN sp_collections c
                        ON cw.collection_id = c.collection_id
                    INNER JOIN sp_words w
                        ON w.word_id = cw.word_id
                    WHERE c.user_id = ? AND w.lang_code = ?
                    GROUP BY c.collection_id, c.name, c.created_at, w.lang_code;";
        $statement = $this->db->prepare($sql);
        $statement->execute([$user_id, $lang_code]);

        return $statement->fetchAll();
    }

    /**
     * Gets the total amount of words included in multiple collections.
     * 
     * @param array $collectionIds The ids of the queried collections.
     * @return int The total amount of words.
     */
    public function totalWords(array $collectionIds): int {
        if (empty($collectionIds)) {
            return 0;
        }
        $sql = "SELECT COUNT(*) as amount
                    FROM sp_collection_words cw
                    INNER JOIN sp_collections c
                        ON cw.collection_id = c.collection_id
                    INNER JOIN sp_words w
                        ON w.word_id = cw.word_id";
        $ids = implode(',', array_fill(0, count($collectionIds), '?'));
        $where = " WHERE cw.collection_id IN (" . $ids . ")";
        $sql .= $where;

        $statement = $this->db->prepare($sql);
        $statement->execute($collectionIds);

        return (int)$statement->fetch()['amount'];
    }

}

?>