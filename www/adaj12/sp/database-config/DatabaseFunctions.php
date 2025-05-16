<?php
interface DatabaseFunctions {
    public function fetchAll();
    public function fetchFiltered($filters);
}
