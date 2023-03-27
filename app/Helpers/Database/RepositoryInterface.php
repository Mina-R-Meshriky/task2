<?php

namespace App\Helpers\Database;

interface RepositoryInterface
{
    public function all();

    public function get(int $id, array $columns = ['*']);

    public function create(array $columns);

    public function update(int $id, array $columns);

    public function delete(int $id);
}