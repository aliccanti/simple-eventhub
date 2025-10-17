<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use App\DTO\EventInputDto;
use Carbon\Carbon;
class EventController extends Controller
{
    public function __construct(private readonly EventService $eventService) {

    }
     public function __invoke(StoreEventRequest $request): JsonResponse
    {
        $inputDto = new EventInputDto(
            title: $request->input('title'),
            description: $request->input('description'),
            date: Carbon::parse($request->input('date')),
            ticketPrice: $request->input('ticket_price'),
            capacity: $request->input('capacity'),
            organizerId: $request->input('organizer_id'),
        );

        $response = $this->eventService->store($inputDto);

        return response()->json($response);
    }
}
