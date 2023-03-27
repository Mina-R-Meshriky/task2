<?php

namespace App\Helpers\Database;

class Repository implements RepositoryInterface
{

    protected Database $db;
    protected string $table;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    protected function qualifyColumns($columns) {
        foreach ($columns as $i => $col) {
            $columns[$i] = "`$this->table`." . ($col === '*' ?  "$col" : "`$col`");
        }
        return $columns;
    }

    public function all(): array
    {
        return $this->db->getMany("SELECT * FROM `{$this->table}`");
    }

    public function get(int $id, array $columns = ['*']): array
    {
        $columns = join(',', $this->qualifyColumns($columns));

        return $this->db->getOne("SELECT {$columns} FROM {$this->table} WHERE id = :id", [
            ':id' => $id
        ]);
    }

    public function create(array $columns): int
    {
        $this->db->query("INSERT INTO {$this->table} (:keys) VALUES (:values)", [
            ':keys' => join(',', array_keys($columns)),
            ':values' => join(',', array_values($columns))
        ]);

        return (int) $this->db->lastInsertedId();
    }

    public function update(int $id, array $columns): int
    {
        $this->db->query("UPDATE {$this->table} SET :set WHERE id = :id", [
            ':id' => $id,
            ':set' => join(', ', array_map(fn($i, $k) => "$k = $i", $columns))
        ]);

        return $id;
    }

    public function delete(int $id): bool
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id", [
            ':id' => $id,
        ]);

        return true;
    }
}