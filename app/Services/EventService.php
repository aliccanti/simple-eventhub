<?php

namespace App\Services;

use App\DTO\EventInputDto;
use App\Exceptions\ParticipantUserCannotCreateEventException;
use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class EventService
{
    public function __construct(protected EventRepositoryInterface $repository,
        protected UserRepositoryInterface $userRepository) {}

    public function store(EventInputDto $dto): Event
    {
        $organizer = $this->userRepository->getById($dto->organizerId);

        if (! $organizer->isOrganizer()) {
            throw new ParticipantUserCannotCreateEventException();
        }

        return $this->repository->create($dto->title, $dto->description, $dto->date, $dto->ticketPrice, $dto->capacity, $organizer->id);
    }
}
