<?php

namespace App\ValueObjects;

use InvalidArgumentException;

final class Email
{
    public function __construct(
        private string $value
    ) {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('E-mail inválido.');
        }

        $this->value = strtolower(trim($value));

    }

    public static function from(string $email): self
    {
        return new self($email);
    }

    public function value(): string
    {
        return $this->value;
    }
}
