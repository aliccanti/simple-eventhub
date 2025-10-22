<?php

namespace App\DTO;

use App\Enums\UserTypeEnum;

final class UserOutputDto
{
    public function __construct(
        public string $fullName,
        public string $mail,
        public UserTypeEnum $type
    ) {}
}
