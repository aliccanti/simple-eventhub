<?php

namespace App\Services;

use App\DTO\PurchaseInputDto;
use App\DTO\PurchaseOutputDto;
use App\Exceptions\CapacityExceededException;
use App\Exceptions\EventSoldOutException;
use App\Exceptions\PaymentNotAuthorizedException;
use App\Exceptions\UserLimitExceededException;
use App\Models\Event;
use App\Models\Purchase;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\PurchaseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthorizerServiceInterface;
use App\Services\Interfaces\NotificationServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseService
{
    public function __construct(protected PurchaseRepositoryInterface $repository,
        protected EventRepositoryInterface $eventRepository,
        protected UserRepositoryInterface $userRepository,
        protected AuthorizerServiceInterface $authorizer,
        protected NotificationServiceInterface $notificationService) {}

    public function store(PurchaseInputDto $dto): PurchaseOutputDto
    {
        $event = $this->eventRepository->getById($dto->eventId);

        if (! $event->hasTicketsAvailable()) {
            throw new EventSoldOutException;
        }

        if ($event->hasExceededCapacity($dto->quantity)) {
            throw new CapacityExceededException;
        }

        $userTotal = $this->repository->quantityByUserAndEvent($dto->userId, $dto->eventId);
        if ($event->hasExceededUserLimitByEvent($userTotal, $dto->quantity)) {
            throw new UserLimitExceededException;
        }

        $authorized = $this->authorizer->authorize();

        if (! $authorized) {
            throw new PaymentNotAuthorizedException;
        }

        $totalAmount = $dto->quantity * $event->ticket_price;

        Log::debug('Iniciando compra de ingresso do usuário '.$dto->userId.' para o evento '.$dto->eventId); // mesmo id de rastreabilidade

        $purchase = DB::transaction(function () use ($dto, $event, $totalAmount) {
            $eventLocked = Event::query()->whereKey($event->getKey())->lockForUpdate()->first();

            if (! $eventLocked->hasTicketsAvailable()) {
                throw new EventSoldOutException;
            }

            $purchase = Purchase::create([
                'user_id' => $dto->userId,
                'event_id' => $dto->eventId,
                'quantity' => $dto->quantity,
                'total_amount' => $totalAmount,
            ]);

            $eventLocked->increment('tickets_sold', $dto->quantity);

            return $purchase->fresh(['event', 'user']);
        });

        DB::afterCommit(function () use ($dto, $event) {
            $emailToSendNotification = $this->userRepository->getEmailByUserId($dto->userId);
            $this->notificationService->notify(email: $emailToSendNotification, eventName: $event->title);
        });

        return new PurchaseOutputDto(
            id: $purchase->id,
            quantity: $purchase->quantity,
            eventId: $purchase->event_id,
            userId: $purchase->user_id,
            totalAmount: $totalAmount
        );
    }
}
