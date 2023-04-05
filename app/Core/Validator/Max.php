<?php

namespace App\Core\Validator;

class Max implements RuleInterface
{
    private int $max;

    public function __construct($max) {
        $this->max = $max;
    }

    public function valid($value): bool
    {
        if(is_string($value)) {
            return strlen($value) <= $this->max;
        } elseif (is_int($value)) {
            return $value <= $this->max;
        }

        return false;
    }

    public function errorMessage(): string
    {
        return "This value should be less than {$this->max}";
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