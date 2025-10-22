<?php

namespace App\Repositories;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\ValueObjects\Mail;

class UserRepository implements UserRepositoryInterface
{
    public function getById(int $userId): ?User
    {
        return User::find($userId);
    }

    public function create(string $fullName, Mail $email, string $password, UserTypeEnum $type): int
    {
        $user = User::create([
            'name' => $fullName,
            'email' => $email->value(),
            'password' => $password,
            'type' => $type->value,
        ]);

        return $user->id;
    }

    public function getEmailByUserId(int $userId): ?Mail
    {
        return Mail::from(User::find($userId)->email);
    }
}
