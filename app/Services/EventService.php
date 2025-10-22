<?php

namespace App\Services;

use App\DTO\EventInputDto;
use App\Exceptions\ParticipantUserCannotCreateEventException;
use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class EventService
{
    public function __construct(protected EventRepositoryInterface $repository,
        protected UserRepositoryInterface $userRepository) {}

    public function store(EventInputDto $dto): Event
    {
        $organizer = $this->userRepository->getById($dto->organizerId);

        if (! $organizer->isOrganizer()) {
            throw new ParticipantUserCannotCreateEventException;
        }

        Log::debug('Criando evento '.$dto->title.' para o usuário '.$organizer->id);

        return $this->repository->create($dto->title, $dto->description, $dto->date, $dto->ticketPrice, $dto->capacity, $organizer->id);
    }
}
