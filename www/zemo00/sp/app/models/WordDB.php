<?php

require_once __DIR__ . "/../core/Model.php";

class WordDB extends Model {
    
    protected string $tableName = 'sp_words';
    protected string|array $primaryKey = 'word_id';
    public ?array $sortingColumns = ['word_id', 'word', 'lang_code', 'last_updated'];

    /**
     * Fetches all words including the language the word is associated with.
     * 
     * @param string $sortingColumn Column for optional sorting.
     * @param string $direction Either ASC or DESC
     * @throws InvalidArgumentException If $direction is not ASC nor DESC.
     * @throws InvalidArgumentException If the column used for sorting is not allowed.
     */
    public function fetchWords(string $sortingColumn = 'word_id', string $direction = 'asc') {
        $sql = "SELECT * FROM $this->tableName w INNER JOIN sp_languages l ON w.lang_code = l.code";
        if (!empty($sortingColumn)) {
            $direction = strtoupper($direction);
            if (!in_array($direction, ["ASC", "DESC"])) {
                throw new InvalidArgumentException("Invalid sort direction: must be 'ASC' or 'DESC'");
            }
            if (!in_array($sortingColumn, $this->sortingColumns)) {
                throw new InvalidArgumentException("Invalid column name");
            }
        
            $sql .= " ORDER BY w.$sortingColumn $direction;";
        }

        $statement = $this->db->prepare($sql);
        $statement->execute();

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

}

?>