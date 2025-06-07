<?php

require_once __DIR__ . "/../core/Model.php";

class WordConceptDB extends Model {
    
    protected string $tableName = 'sp_word_concepts';
    protected string|array $primaryKey = ['concept_id', 'word_id'];
    public ?array $sortingColumns = ['concept_id', 'word_id'];

    /**
     * Fetches all concepts assigned to a specific word.
     * 
     * @param string|int $word_id The ID of the word.
     * @return array Fetched concepts.
     */
    public function fetchConcepts(string|int $word_id): array {
        $sql = "SELECT concept_id, name, description
	                FROM $this->tableName
                    LEFT JOIN sp_concepts
    	                USING (concept_id)
                    WHERE word_id = ?;";
        $statement = $this->db->prepare($sql);
        $statement->execute([$word_id]);

        return $statement->fetchAll();
    }

    /**
     * Fetches a random ID of a transated word.
     * 
     * @param string|int $word_id_from The word to be translated.
     * @param string $lang_to The target language code.
     * @return int|null The ID of a translation.
     */
    public function fetchTranslation(string|int $word_id_from, string $lang_to): ?int {
        $sql = "SELECT wc2.word_id as id_to
                    FROM sp_word_concepts wc1
                    INNER JOIN sp_word_concepts wc2
                        ON wc1.concept_id = wc2.concept_id AND wc1.word_id != wc2.word_id
                    INNER JOIN sp_words w
                        ON wc2.word_id = w.word_id
                    WHERE wc1.word_id = ? AND w.lang_code = ?
                    ORDER BY RAND()
                    LIMIT 1";
        $statement = $this->db->prepare($sql);
        $statement->execute([$word_id_from, $lang_to]);

        $result = $statement->fetch();
        return $result ? (int)$result['id_to'] : null;
    }

    /**
     * Fetches three IDs of words that do not have the same meaning
     * as the word of the provided ID.
     * 
     * @param string|int $word_id_from The ID of the word to be mistranslated.
     * @param string $lang_to The target language code.
     * @return array Three IDs of mistranslated words.
     */
    public function fetchIncorrectTranslations(string|int $word_id_from, string $lang_to): array {
        $conceptSql = "SELECT concept_id FROM sp_word_concepts WHERE word_id = ?";
        $statement1 = $this->db->prepare($conceptSql);
        $statement1->execute([$word_id_from]);
        $sourceConcepts = $statement1->fetchAll(PDO::FETCH_COLUMN);

        if (empty($sourceConcepts)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($sourceConcepts), '?'));

        $excludeSql = "SELECT DISTINCT wc.word_id
                       FROM sp_word_concepts wc
                       WHERE wc.concept_id IN ($placeholders)";
        $statement2 = $this->db->prepare($excludeSql);
        $statement2->execute($sourceConcepts);
        $excludeWordIds = $statement2->fetchAll(PDO::FETCH_COLUMN);

        if (empty($excludeWordIds)) {
            return [];
        }

        $exclPlaceholders = implode(',', array_fill(0, count($excludeWordIds), '?'));

        $sql = "SELECT DISTINCT wc.word_id
                FROM sp_word_concepts wc
                INNER JOIN sp_words w ON wc.word_id = w.word_id
                WHERE wc.word_id NOT IN ($exclPlaceholders) AND w.lang_code = ?
                ORDER BY RAND()
                LIMIT 3";

        $params = array_merge($excludeWordIds, [$lang_to]);
        $statement3 = $this->db->prepare($sql);
        $statement3->execute($params);

        return $statement3->fetchAll(PDO::FETCH_COLUMN);
    }

}

?>