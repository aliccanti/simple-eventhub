<?php

namespace App\Exceptions;

enum ErrorTypeEnum: string
{
    case EVENT_SOLD_OUT = 'urn:events:sold-out';
    case CAPACITY_EXCEEDED = 'urn:events:capacity-exceeded';
    case USER_LIMIT_EXCEEDED = 'urn:purchases:user-limit-exceeded';
    case PAYMENT_NOT_AUTH = 'urn:payments:not-authorized';
    case PARTICIPANT_CANNOT_CREATE_EVENT = 'urn:user:participant-cannot-create-event';
}
