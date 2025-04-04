<?php 

interface DatabaseOperations {
    public function fetch($args);
    public function find();
    public function findBy($field, $value);

}

?>