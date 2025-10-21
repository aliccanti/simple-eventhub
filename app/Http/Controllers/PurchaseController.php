<?php

namespace App\Http\Controllers;

use App\DTO\PurchaseInputDto;
use App\Http\Requests\StorePurchaseRequest;
use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    public function __construct(private readonly PurchaseService $service) {}

    public function __invoke(StorePurchaseRequest $request): JsonResponse
    {
        $inputDto = new PurchaseInputDto(
            quantity: $request->input('quantity'),
            eventId: $request->input('event_id'),
            userId: $request->input('user_id'),
        );

        $response = $this->service->store($inputDto);

        return response()->json($response);
    }
}
