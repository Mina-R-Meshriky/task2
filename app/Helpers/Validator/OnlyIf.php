<?php

namespace App\Helpers\Validator;


class OnlyIf implements RuleInterface
{

    private $cond;


    public function __construct($cond) {
        $this->cond = $cond;
    }

    public function valid($value): bool
    {
        return  $this->cond;
    }

    public function errorMessage(): string
    {
        return "This value is required";
    }

    public function isStopping(): bool
    {
        return true;
    }

    public function unsetDataKey(): bool
    {
        return true;
    }

}