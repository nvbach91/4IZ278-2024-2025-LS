<?php

require_once __DIR__ . "/../core/Model.php";

class WordDB extends Model {
    
    protected string $tableName = 'sp_words';
    protected string|array $primaryKey = 'word_id';
    public ?array $sortingColumns = ['word_id', 'word', 'lang_code', 'last_updated'];

    /**
     * Fetches all words including the language the word is associated with. Enables
     * pagination via LIMIT and OFFSET.
     * 
     * @param string $sortingColumn Column for optional sorting.
     * @param string $direction Either ASC or DESC
     * @param int $limit Value for the LIMIT clause.
     * @param int $offset Value for the OFFSET clause.
     * @param string $lang Optional language filtering.
     * @throws InvalidArgumentException If $direction is not ASC nor DESC.
     * @throws InvalidArgumentException If the column used for sorting is not allowed.
     * @return array Fetched words.
     */
    public function fetchWords(string $sortingColumn = 'word_id', string $direction = 'asc', int $limit = 20, int $offset = 0, ?string $lang = null): array {
        $sql = "SELECT *
                    FROM $this->tableName w
                    INNER JOIN sp_languages l
                        ON w.lang_code = l.code";
        $params = [];
        if (isset($lang)) {
            $sql .= " WHERE l.code = ?";
            $params[] = $lang;
        }
        if (!empty($sortingColumn)) {
            $direction = strtoupper($direction);
            if (!in_array($direction, ["ASC", "DESC"])) {
                throw new InvalidArgumentException("Invalid sort direction: must be 'ASC' or 'DESC'");
            }
            if (!in_array($sortingColumn, $this->sortingColumns)) {
                throw new InvalidArgumentException("Invalid column name");
            }
        
            $sql .= " ORDER BY w.$sortingColumn $direction";
        }
        $sql .= " LIMIT $limit OFFSET $offset;";


        $statement = $this->db->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll();
    }

    /**
     * Fetches a single word usin the ID. Fetches the word and the icon
     * of the associated language.
     * 
     * @param string|int $word_id The ID of the word.
     * @return array The fetched words.
     */
    public function fetchWord(string|int $word_id): array {
        $sql = "SELECT word, icon, word_id, w.last_updated, lang_code
                    FROM $this->tableName w
                    INNER JOIN sp_languages l
                        ON w.lang_code = l.code
                    WHERE word_id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$word_id]);

        return $statement->fetch();
    }

    /**
     * Fetches the count of all words belonging to a specific language.
     * 
     * @param string $lang Language code.
     * @return int Amount of rows.
     */
    public function fetchCountByLang(string $lang): int {
        $sql = "SELECT COUNT(*) as count FROM $this->tableName WHERE lang_code = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$lang]);

        return $statement->fetch()['count'];
    }

}

?>