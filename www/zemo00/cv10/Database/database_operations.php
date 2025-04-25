<?php

interface DatabaseOperations {
    
    public function insert($args): bool;

    public function fetch($args);
    public function fetchAll();

    public function update($args): bool;

    public function delete($args): bool;

}

?>