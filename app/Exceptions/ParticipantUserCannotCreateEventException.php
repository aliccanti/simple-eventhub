<?php

namespace App\Exceptions;

use App\Exceptions\ErrorTypeEnum;
use App\Exceptions\DomainException;

class ParticipantUserCannotCreateEventException extends DomainException
{
    public function __construct(string $message = 'Somente organizadores podem criar eventos.')
    {
        parent::__construct($message);
    }

    public function status(): int { return 409; }
    public function type(): string { return ErrorTypeEnum::PARTICIPANT_CANNOT_CREATE_EVENT->value; }
    public function title(): string { return 'Apenas usuários do tipo organizador podem criar eventos'; }
}
