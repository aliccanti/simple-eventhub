<?php

namespace App\DTO;

use App\Enums\UserTypeEnum;
use App\ValueObjects\Email;

final class UserInputDto
{
    public function __construct(
        public string $fullName,
        public Email $email,
        public string $password,
        public UserTypeEnum $type
    ) {}
}
