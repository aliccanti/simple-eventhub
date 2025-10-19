<?php

namespace App\Repositories\Interfaces;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\ValueObjects\Email;

interface UserRepositoryInterface
{
    public function getById(int $userId): ?User;

    public function create(string $fullName, Email $email, string $password, UserTypeEnum $type): User;

    public function getEmailByUserId(int $userId): ?Email;
}
