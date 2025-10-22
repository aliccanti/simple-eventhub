<?php

namespace Tests\Unit;

use App\DTO\EventInputDto;
use App\Exceptions\ParticipantUserCannotCreateEventException;
use App\Models\User;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\EventService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\MockObject\MockObject;
use App\DTO\EventOutputDto;
use Tests\TestCase;

class EventServiceTest extends TestCase
{
    use RefreshDatabase;

    private EventRepositoryInterface&MockObject $eventRepo;

    private UserRepositoryInterface&MockObject $userRepo;

    private EventService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventRepo = $this->createMock(EventRepositoryInterface::class);
        $this->userRepo = $this->createMock(UserRepositoryInterface::class);

        $this->service = new EventService($this->eventRepo, $this->userRepo);

    }

    public function test_store_throws_when_user_is_not_organizer(): void
    {
        $user = User::factory()->create();

        $this->userRepo->expects($this->once())
            ->method('getById')
            ->with($user->id)
            ->willReturn($user);

        $this->eventRepo->expects($this->never())->method('create');

        $dto = new EventInputDto(
            title: 'meetup #3',
            description: 'discussões',
            date: Carbon::parse('2025-11-10'),
            ticketPrice: '58.60',
            capacity: 50,
            organizerId: $user->id
        );

        $this->expectException(ParticipantUserCannotCreateEventException::class);

        $this->service->store($dto);
    }

    public function test_store_creates_events_successfully(): void
    {
        $user = User::factory()->organizer()->create();

        $this->userRepo->expects($this->once())
            ->method('getById')
            ->with($user->id)
            ->willReturn($user);

        $dto = new EventInputDto(
            title: 'meetup #3',
            description: 'discussões',
            date: Carbon::parse('2025-11-10'),
            ticketPrice: '58.6',
            capacity: 50,
            organizerId: $user->id
        );

        $this->eventRepo->expects($this->once())
            ->method('create')
            ->with($dto->title, $dto->description, $dto->date, $dto->ticketPrice, $dto->capacity, $user->id);

        $out = $this->service->store($dto);

        $this->assertInstanceOf(EventOutputDto::class, $out);
        $this->assertSame($user->id, $out->organizerId);
        $this->assertSame($dto->title, $out->title);
        $this->assertSame('58.6', (string) $out->ticketPrice);

    }
}
