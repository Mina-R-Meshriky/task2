<?php

namespace App\Core\Validator;

class Integer implements RuleInterface
{

    public function valid($value): bool
    {
        return is_int($value) || ctype_digit($value);
    }

    public function errorMessage(): string
    {
        return "Please, provide the data of indicated type";
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