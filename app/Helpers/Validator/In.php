<?php

namespace App\Helpers\Validator;

class In implements RuleInterface
{
    public array $vars;

    public function __construct(...$vars) {
        $this->vars = $vars;
    }

    public function valid($value): bool
    {
       return in_array($value, $this->vars);
    }

    public function errorMessage(): string
    {
        return "Must be one of: " .join(', ', $this->vars);
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