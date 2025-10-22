<?php

namespace App\Exceptions;

class ConnectionException extends DomainException
{
    public function __construct(string $message = 'Falha na autorização')
    {
        parent::__construct($message);
    }

    public function status(): int
    {
        return 422;
    }

    public function type(): string
    {
        return ErrorTypeEnum::USER_LIMIT_EXCEEDED->value; // atualizar
    }

    public function title(): string
    {
        return 'Falha na autorização:';
    }
}
