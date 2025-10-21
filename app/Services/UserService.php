<?php

namespace App\Services;

use App\DTO\UserInputDto;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepositoryInterface $repository) {}

    public function create(UserInputDto $dto): User
    {
        return $this->repository->create($dto->fullName, $dto->email, Hash::make($dto->password), $dto->type);
    }
}
