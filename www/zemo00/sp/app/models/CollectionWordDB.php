<?php

require_once __DIR__ . "/../core/Model.php";

class CollectionWordDB extends Model {
    
    protected string $tableName = 'sp_collection_words';
    protected string|array $primaryKey = ['collection_id', 'word_id'];
    public ?array $sortingColumns = ['collection_id'];

    /**
     * Fetches all words that are included in a specific collection.
     * 
     * @param string|int $collection_id The ID of the collection.
     * @return array Fetched words.
     */
    public function fetchWords(string|int $collection_id): array {
        $sql = "SELECT word_id, word, icon, lang_code
                    FROM sp_words w
                    INNER JOIN $this->tableName
                        USING (word_id)
                    INNER JOIN sp_languages l
    	                ON w.lang_code = l.code
                    WHERE collection_id = ?;";
        $statement = $this->db->prepare($sql);
        $statement->execute([$collection_id]);

        return $statement->fetchAll();
    }

    /**
     * Fetches random word IDs related to certain.
     * 
     * @param array $collectionIds IDs of collections to source words from.
     * @param int $amount The amount of fetched words
     * @return array IDs of randomised words.
     */
    public function fetchRandomWordIds(array $collectionIds, int $amount): array {
        $sql = "SELECT word_id
                    FROM sp_collection_words
                    WHERE collection_id IN (" . implode(',', array_fill(0, count($collectionIds), '?')) . ")
                    ORDER BY RAND()
                    LIMIT " . (int)$amount;
        $statement = $this->db->prepare($sql);
        $statement->execute($collectionIds);

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

}

?>