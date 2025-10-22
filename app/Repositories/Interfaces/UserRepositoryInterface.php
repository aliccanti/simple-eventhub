<?php

namespace App\Repositories\Interfaces;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\ValueObjects\Mail;

interface UserRepositoryInterface
{
    public function getById(int $userId): ?User;

    public function create(string $fullName, Mail $email, string $password, UserTypeEnum $type): int;

    public function getEmailByUserId(int $userId): ?Mail;
}
