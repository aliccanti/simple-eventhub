<?php

namespace App\Services;

use App\DTO\EventInputDto;
use App\DTO\EventOutputDto;
use App\Exceptions\ParticipantUserCannotCreateEventException;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class EventService
{
    public function __construct(protected EventRepositoryInterface $repository,
        protected UserRepositoryInterface $userRepository
) {}

    public function store(EventInputDto $dto): EventOutputDto
    {
        $organizer = $this->userRepository->getById($dto->organizerId);

        if (! $organizer->isOrganizer()) {
            throw new ParticipantUserCannotCreateEventException;
        }

        $eventId = $this->repository->create($dto->title, $dto->description, $dto->date, $dto->ticketPrice, $dto->capacity, $organizer->id);

        return new EventOutputDto(
            id: $eventId,
            title: $dto->title,
            description: $dto->description,
            date: $dto->date,
            ticketPrice: $dto->ticketPrice,
            capacity: $dto->capacity,
            organizerId: $dto->organizerId,
        );
    }
}
