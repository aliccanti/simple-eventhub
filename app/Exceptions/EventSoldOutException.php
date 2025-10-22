<?php

namespace App\Exceptions;

class EventSoldOutException extends DomainException
{
    public function __construct(string $message = 'O evento não possui ingressos disponíveis.')
    {
        parent::__construct($message);
    }

    public function status(): int
    {
        return 409;
    }

    public function type(): string
    {
        return ErrorTypeEnum::EVENT_SOLD_OUT->value;
    }

    public function title(): string
    {
        return 'Evento lotado';
    }
}
