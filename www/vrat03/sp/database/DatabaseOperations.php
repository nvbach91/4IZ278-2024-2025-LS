<?php

interface DatabaseOperations {
    public function fetchAll($args);
    public function countRecords($args);
    public function fetchPagination($offset, $numberOfItemsPerPage);
}

?>