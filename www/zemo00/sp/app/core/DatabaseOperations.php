<?php

interface DatabaseOperations{

    public function insert(array $data): bool;

    public function fetchById(string|int|array $id): ?array;

    public function fetchWhere(array $conditions, ?array $columns = null): array;

    public function fetchAll(): array;

    public function update(string|int|array $id, array $data): bool;

    public function delete(string|int|array $id): bool;

}

?>