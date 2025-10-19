<?php

namespace App\Repositories;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\ValueObjects\Email;

class UserRepository implements UserRepositoryInterface
{
    public function getById(int $userId): ?User
    {
        return User::find($userId);
    }

    public function create(string $fullName, Email $email, string $password, UserTypeEnum $type): User
    {
        return User::create([
            'name' => $fullName,
            'email' => $email->value(),
            'password' => $password,
            'type' => $type->value,
        ]);
    }

    public function getEmailByUserId(int $userId): ?Email
    {
        return Email::from(User::find($userId)->email);
    }
}
