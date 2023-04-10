<?php

namespace App\Core\Database;

interface RepositoryInterface
{
    public function getTable();

    public function all(array $filters = []);

    public function get(int $id, array $columns = ['*']);

    public function create(array $columns);

    public function bulkDelete(array $ids);

    public function delete(int $id);
}