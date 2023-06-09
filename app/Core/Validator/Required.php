<?php

namespace App\Core\Validator;

class Required implements RuleInterface
{

    public function valid($value): bool
    {
        return isset($value) && $value !== '';
    }

    public function errorMessage(): string
    {
        return "Please, submit required data";
    }

    public function isStopping(): bool
    {
        return true;
    }

    public function unsetDataKey(): bool
    {
        return false;
    }
}