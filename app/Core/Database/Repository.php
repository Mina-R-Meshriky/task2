<?php

namespace App\Core\Database;

class Repository implements RepositoryInterface
{

    protected Database $db;
    protected string $table;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    protected function qualifyColumns($columns) {
        foreach ($columns as $i => $col) {
            $columns[$i] = "`$this->table`." . ($col === '*' ?  "$col" : "`$col`");
        }
        return $columns;
    }

    public function all(): ?array
    {
        $records = $this->db->getMany("SELECT * FROM {$this->table}");

        return $records !== false ? $records : null;
    }

    public function get(int $id, array $columns = ['*']): ?array
    {
        $columns = join(',', $this->qualifyColumns($columns));

        $record = $this->db->getOne("SELECT {$columns} FROM {$this->table} WHERE id = :id", [
            ':id' => $id
        ]);

        return $record !== false ? $record : null;
    }

    public function getByColumn(string $column, $value, array $columns = ['*']): ?array
    {
        $columns = join(',', $this->qualifyColumns($columns));

        $record = $this->db->getOne("SELECT {$columns} FROM {$this->table} WHERE {$column} = :v", [
            ':v' => $value
        ]);

        return $record !== false ? $record : null;
    }

    public function create(array $columns): int
    {
        $keys = join(',', array_keys($columns));

        $q = rtrim(str_repeat('?,', count($columns)), ',');

        $this->db->query("INSERT INTO {$this->table} ($keys) VALUES ($q)", array_values($columns));

        return (int) $this->db->lastInsertedId();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->query("DELETE FROM {$this->table} WHERE id = :id", [
            ':id' => $id,
        ]);

        return $stmt->rowCount();
    }

    public function bulkDelete(array $ids): int
    {
        $q = rtrim(str_repeat("?,", count($ids)),',');

        $stmt = $this->db->query("DELETE FROM {$this->table} WHERE id IN ($q)", $ids);

        return $stmt->rowCount();
    }
}