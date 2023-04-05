<?php

namespace App\Domain\Shared\VO;

class Dimension
{
    public ?float $value;
    public string $formatted;

    public function __construct(?float $value) {

        $this->value = $value;

        if(is_null($value)) {
            $this->formatted = '';
        } else {
            $this->formatted = number_format($value);
        }

    }

    public static function from(?float $value): self
    {
        return new self($value);
    }
}