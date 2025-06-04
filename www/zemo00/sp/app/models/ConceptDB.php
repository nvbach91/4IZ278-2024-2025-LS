<?php

require_once __DIR__ . "/../core/Model.php";

class ConceptDB extends Model {
    
    protected string $tableName = 'sp_concepts';
    protected string|array $primaryKey = 'concept_id';
    public ?array $sortingColumns = ['concept_id', 'name'];

}

?>