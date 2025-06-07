<?php

require_once __DIR__ . "/../core/Model.php";

class ConceptDB extends Model {
    
    protected string $tableName = 'sp_concepts';
    protected string|array $primaryKey = 'concept_id';
    public ?array $sortingColumns = ['concept_id', 'name'];

    public function search($term) {
        $term = trim($term);
        $term = "%$term%";

        $sql = "SELECT * FROM sp_concepts WHERE name LIKE :term ORDER BY name";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':term', $term, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();

    }
}
?>