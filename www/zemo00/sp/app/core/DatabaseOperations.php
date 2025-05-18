<?php

interface DatabaseOperations{

    public function insert(array $data): bool;

    public function fetchById(string|int $id): ?array;

    public function fetchWhere(array $conditions): array;

    public function fetchAll(): array;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}

?>