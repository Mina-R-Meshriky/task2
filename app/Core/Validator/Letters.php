<?php

namespace App\Core\Validator;

class Letters implements RuleInterface
{

    public function valid($value): bool
    {
        return is_string($value);
    }

    public function errorMessage(): string
    {
        return "This value should be a string";
    }

    public function isStopping(): bool
    {
        return false;
    }

    public function unsetDataKey(): bool
    {
        return false;
    }
}