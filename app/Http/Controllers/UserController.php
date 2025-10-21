<?php

namespace App\Http\Controllers;

use App\DTO\UserInputDto;
use App\Enums\UserTypeEnum;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use App\ValueObjects\Email;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function __invoke(StoreUserRequest $request): JsonResponse
    {
        $inputDto = new UserInputDto(
            fullName: $request->input('name'),
            email: Email::from($request->input('email')),
            password: $request->input('password'),
            type: UserTypeEnum::from($request->input('type')),
        );

        $response = $this->userService->create($inputDto);

        return response()->json($response);
    }
}
