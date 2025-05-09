<?php
interface DatabaseOperations
{
    public function find($args);
    public function insert($args);
    public function countRecords($args);
}
