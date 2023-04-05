<?php

namespace App\Helpers\Validator;

class Integer implements RuleInterface
{

    public function valid($value): bool
    {
        return is_int($value) || ctype_digit($value);
    }

    public function errorMessage(): string
    {
        return "This value should be an integer";
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