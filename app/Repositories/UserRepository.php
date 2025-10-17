<?php

namespace App\Repositories;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Enums\UserTypeEnum;
use App\ValueObjects\Email;

class UserRepository implements UserRepositoryInterface
{
    public function create(string $fullName, Email $email, string $password, UserTypeEnum $type): User
    {
        return User::create([
            'name' => $fullName,
            'email' => $email->value(),
            'password' => $password,
            'type' => $type->value
        ]);
    }
}
