<?php

namespace App\Core\Validator;

class Unique implements RuleInterface
{
    use DatabaseRuleTrait;

    private string $table;
    private string $column;
    private $value;


    public function __construct($table, $column) {
        $this->table = $table;
        $this->column = $column;
    }

    public function valid($value): bool
    {
        if(!$value) return true;

        $this->value = $value;

        return !$this->exists($value);
    }

    public function errorMessage(): string
    {
        return "{$this->value} has already been taken";
    }

    public function isStopping(): bool
    {
        return false;
    }

    public function unsetDataKey(): bool
    {
        return false;
    }


    private function exists($value): bool
    {
        return (bool) $this->getDatabase()
                    ->getOne(
                        "SELECT `id` FROM {$this->table} WHERE {$this->column} = ?",
                        [$value]
                    );
    }
}