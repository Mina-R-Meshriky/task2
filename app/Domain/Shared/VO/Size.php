<?php

namespace App\Domain\Shared\VO;

class Size
{
    public ?float $value;
    public string $formatted;

    public function __construct(?string $value)
    {

        $this->value = $value;

        if (is_null($value)) {
            $this->formatted = '';
        } else {
            if (str_contains($value, '.00')) {
                $this->formatted = number_format($value)." MB";
            } else {
                $this->formatted = number_format($value, 2)." MB";
            }
        }

    }

    public static function from(?string $value): self
    {
        return new self($value);
    }
}