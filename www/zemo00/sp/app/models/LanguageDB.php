<?php

require_once __DIR__ . "/../core/Model.php";

class LanguageDB extends Model {
    
    protected string $tableName = 'sp_languages';
    protected string|array $primaryKey = 'code';
    public ?array $sortingColumns = ['name', 'code'];

}

?>