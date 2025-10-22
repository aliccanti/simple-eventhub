<?php

namespace Tests\Unit;

use App\DTO\PurchaseInputDto;
use App\Exceptions\CapacityExceededException;
use App\Exceptions\EventSoldOutException;
use App\Exceptions\PaymentNotAuthorizedException;
use App\Exceptions\UserLimitExceededException;
use App\Models\Event;
use App\Models\User;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\PurchaseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthorizerServiceInterface;
use App\Services\Interfaces\NotificationServiceInterface;
use App\Services\PurchaseService;
use App\ValueObjects\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class PurchaseServiceTest extends TestCase
{
    use RefreshDatabase;

    private PurchaseRepositoryInterface&MockObject $purchaseRepo;

    private EventRepositoryInterface&MockObject $eventRepo;

    private UserRepositoryInterface&MockObject $userRepo;

    private AuthorizerServiceInterface&MockObject $authorizer;

    private NotificationServiceInterface&MockObject $notifier;

    private PurchaseService&MockObject $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->purchaseRepo = $this->createMock(PurchaseRepositoryInterface::class);
        $this->eventRepo = $this->createMock(EventRepositoryInterface::class);
        $this->userRepo = $this->createMock(UserRepositoryInterface::class);
        $this->authorizer = $this->createMock(AuthorizerServiceInterface::class);
        $this->notifier = $this->createMock(NotificationServiceInterface::class);

        $this->service = new PurchaseService($this->purchaseRepo, $this->eventRepo, $this->userRepo, $this->authorizer, $this->notifier);

    }

    public function test_store_throws_event_sold_out_when_no_tickets_available(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'capacity' => 50,
            'tickets_sold' => 50,
        ]);

        $this->eventRepo->method('getById')->with($event->id)->willReturn($event);

        $dto = new PurchaseInputDto(
            userId: $user->id,
            eventId: $event->id,
            quantity: 1
        );

        $this->expectException(EventSoldOutException::class);

        $this->service->store($dto);
    }

    public function test_store_throws_capacity_exceeded_when_quantity_exceeds_remaining(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'capacity' => 100,
            'tickets_sold' => 98,
        ]);

        $this->eventRepo->method('getById')->with($event->id)->willReturn($event);

        $dto = new PurchaseInputDto(
            userId: $user->id,
            eventId: $event->id,
            quantity: 3
        );

        $this->expectException(CapacityExceededException::class);

        $this->service->store($dto);
    }

    public function test_store_throws_user_limit_exceeded_when_user_is_over_event_limit(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $this->eventRepo->method('getById')->with($event->id)->willReturn($event);

        $this->purchaseRepo->method('quantityByUserAndEvent')->willReturn(14);

        $dto = new PurchaseInputDto(
            userId: $user->id,
            eventId: $event->id,
            quantity: 2
        );

        $this->expectException(UserLimitExceededException::class);

        $this->service->store($dto);
    }

    public function test_store_throws_payment_not_authorized_when_gateway_denies(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $this->eventRepo->method('getById')->with($event->id)->willReturn($event);

        $this->authorizer->expects($this->once())->method('authorize')->willReturn(false);

        $dto = new PurchaseInputDto(
            userId: $user->id,
            eventId: $event->id,
            quantity: 1
        );

        $this->expectException(PaymentNotAuthorizedException::class);

        $this->service->store($dto);
    }

    public function test_store_creates_purchase_successfully(): void
    {
        $user = User::factory()->create();

        $event = Event::factory()->create();

        $this->eventRepo->expects($this->once())
            ->method('getById')
            ->with($event->id)
            ->willReturn($event);

        $this->purchaseRepo->expects($this->once())
            ->method('quantityByUserAndEvent')
            ->with($user->id, $event->id)
            ->willReturn(0);

        $this->authorizer->expects($this->once())
            ->method('authorize')
            ->willReturn(true);

        $this->userRepo->expects($this->once())
            ->method('getEmailByUserId')
            ->with($user->id)
            ->willReturn(new Email($user->email));

        $dto = new PurchaseInputDto(
            userId: $user->id,
            eventId: $event->id,
            quantity: 3
        );

        $out = $this->service->store($dto);

        $this->assertSame(3, $out->quantity);
        $this->assertSame($event->id, $out->eventId);
        $this->assertSame($user->id, $out->userId);
    }
}
