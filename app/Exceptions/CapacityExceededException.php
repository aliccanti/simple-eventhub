<?php

namespace App\Exceptions;

class CapacityExceededException extends DomainException
{
    public function __construct(string $message = 'Quantidade de ingressos insuficientes.')
    {
        parent::__construct($message);
    }

    public function status(): int
    {
        return 422;
    }

    public function type(): string
    {
        return ErrorTypeEnum::CAPACITY_EXCEEDED->value;
    }

    public function title(): string
    {
        return 'Quantidade de ingressos insuficiente';
    }
}
