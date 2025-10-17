<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Enums\UserTypeEnum;
use App\ValueObjects\Email;

interface UserRepositoryInterface
{
    public function getById(int $userId): ?User;

    public function create(string $fullName, Email $email, string $password, UserTypeEnum $type): User;
}
