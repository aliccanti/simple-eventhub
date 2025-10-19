<?php

namespace App\Exceptions;

use App\Exceptions\ErrorTypeEnum;
use App\Exceptions\DomainException;

class PaymentNotAuthorizedException extends DomainException
{
    public function __construct(string $message = 'Compra não autorizada pelo serviço externo.')
    {
        parent::__construct($message);
    }

    public function status(): int { return 422; }
    public function type(): string { return ErrorTypeEnum::PAYMENT_NOT_AUTH->value; }
    public function title(): string { return 'Pagamento não autorizado'; }
}
