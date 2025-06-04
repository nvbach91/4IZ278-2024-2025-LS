<?php

require_once __DIR__ . "/../core/Model.php";

class GameWordDB extends Model {
    
    protected string $tableName = 'sp_game_words';
    protected string|array $primaryKey = ['game_id', 'word_id'];

}

?>