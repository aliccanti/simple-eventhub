<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Services\Interfaces\AuthorizerServiceInterface;
use App\Services\Interfaces\NotificationServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchase_executes_successfully(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $this->mock(AuthorizerServiceInterface::class, function ($mock) {
            $mock->shouldReceive('authorize')->once()->andReturn(true);
        });

        $this->mock(NotificationServiceInterface::class, function ($mock) {
            $mock->shouldReceive('notify')->once();
        });

        $response = $this->postJson('/api/buy-ticket', [
            'quantity' => 3,
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response->assertStatus(200);
    }

    #[DataProvider('invalidPayloads')]
    public function test_purchase_validates_payload(array $override, array $expectedErrors): void
    {
        $base = [
            'quantity' => 3,
            'event_id' => 2,
            'user_id' => 1,
        ];

        $res = $this->postJson('/api/users', array_merge($base, $override));
        $res->assertUnprocessable()->assertJsonValidationErrors($expectedErrors);
    }

    public static function invalidPayloads(): array
    {
        return [
            'missing name' => [['name' => null], ['name']],
            'invalid type' => [['type' => -5], ['type']],
            'password incorrect' => [['password' => '123'], ['password']],
            'invalid email' => [['email' => 'arroadoze'], ['email']],
        ];
    }


}
