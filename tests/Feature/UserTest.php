<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_executes_successfully(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Melissa Dolores',
            'email' => 'melissa@gmail.com',
            'password' => 'melissa123',
            'type' => 'participant',
        ]);

        $response->assertStatus(200);
    }

    #[DataProvider('invalidPayloads')]
    public function test_event_validates_payload(array $override, array $expectedErrors): void
    {
        $base = [
            'name' => 'Melissa Dolores',
            'email' => 'melissa@gmail.com',
            'password' => 'melissa123',
            'type' => 'participant',
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
