<?php

require_once __DIR__ . "/../core/Model.php";

class Word extends Model {
    
    protected $tableName = 'sp_words';
    protected $primaryKey = 'word_id';

}

?>