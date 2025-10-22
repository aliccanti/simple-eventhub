<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use PHPUnit\Framework\MockObject\MockObject;
use App\DTO\UserInputDto;
use App\DTO\UserOutputDto;
use App\Enums\UserTypeEnum;
use App\ValueObjects\Mail;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    // use RefreshDatabase;

    private UserRepositoryInterface&MockObject $userRepo;

    private UserService $service;


    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepo = $this->createMock(UserRepositoryInterface::class);
        $this->service = new UserService($this->userRepo);

    }

    public function test_store_creates_users_successfully(): void
    {
        $dto = new UserInputDto(
            fullName: 'Ana Dev',
            mail: 'ana@example.com',
            password: 'Secr3t#123',
            type: UserTypeEnum::ORGANIZER,
        );

        $this->userRepo->expects($this->once())
            ->method('create')
            ->with(
                $this->equalTo($dto->fullName),
                $this->callback(function ($mail) use ($dto) {
                    return $mail instanceof Mail && $mail->value() === $dto->mail;
                }),
                $this->callback(function (string $hashed) use ($dto) {
                    return Hash::check($dto->password, $hashed);
                }),
                $this->equalTo(UserTypeEnum::ORGANIZER),
            );

        $out = $this->service->create($dto);
        $this->assertInstanceOf(UserOutputDto::class, $out);
        $this->assertSame('Ana Dev', $out->fullName);
        $this->assertSame('ana@example.com', $out->mail);

    }
}
