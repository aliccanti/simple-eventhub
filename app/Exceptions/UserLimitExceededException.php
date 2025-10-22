<?php

namespace App\Exceptions;

class UserLimitExceededException extends DomainException
{
    public function __construct(string $message = 'O usuário não pode comprar mais de 15 ingressos por evento.')
    {
        parent::__construct($message);
    }

    public function status(): int
    {
        return 422;
    }

    public function type(): string
    {
        return ErrorTypeEnum::USER_LIMIT_EXCEEDED->value;
    }

    public function title(): string
    {
        return 'Limite por usuário excedido';
    }
}
