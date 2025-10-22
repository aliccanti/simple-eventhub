<?php

namespace App\Exceptions;

class ConnectionException extends DomainException
{
    public function __construct(string $message = 'Falha na conexão com autorizador externo.')
    {
        parent::__construct($message);
    }

    public function status(): int
    {
        return 422;
    }

    public function type(): string
    {
        return ErrorTypeEnum::CONNECTION_FAILED->value;
    }

    public function title(): string
    {
        return 'Falha na autorização com autorizador externo';
    }
}
