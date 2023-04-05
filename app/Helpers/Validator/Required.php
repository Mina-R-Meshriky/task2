<?php

namespace App\Helpers\Validator;

class Required implements RuleInterface
{

    public function valid($value): bool
    {
        return isset($value) && $value !== '';
    }

    public function errorMessage(): string
    {
        return "This value is required";
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