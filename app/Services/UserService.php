<?php

namespace App\Services;

use App\DTO\UserInputDto;
use App\DTO\UserOutputDto;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\ValueObjects\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class UserService
{
    public function __construct(protected UserRepositoryInterface $repository) {}

    public function create(UserInputDto $dto): UserOutputDto
    {
        Log::debug('Criando usuário '.$dto->fullName);

        $userId = $this->repository->create($dto->fullName, Mail::from($dto->mail), Hash::make($dto->password), $dto->type);

        return new UserOutputDto(
            fullName: $dto->fullName,
            mail: $dto->mail,
            type: $dto->type,
        );
    }
}
