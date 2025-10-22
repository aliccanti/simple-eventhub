<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_executes_successfully(): void
    {
        $user = User::factory()->organizer()->create();

        $response = $this->postJson('/api/events', [
            'organizer_id' => $user->id,
            'title' => 'meetup #3',
            'description' => 'discussões técnicas',
            'date' => '2025-11-10',
            'ticket_price' => 58.6,
            'capacity' => 45,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'title',
            'description',
            'date' ,
            'ticket_price' ,
            'capacity',
        ]);
    }

    public function test_user_participant_cannot_create_event(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/events', [
            'organizer_id' => $user->id,
            'title' => 'meetup #3',
            'description' => 'discussões técnicas',
            'date' => '2025-11-10',
            'ticket_price' => 58.6,
            'capacity' => 45,
        ]);

        $response->assertStatus(409);

    }

    #[DataProvider('invalidPayloads')]
    public function test_event_validates_payload(array $override, array $expectedErrors): void
    {
        $user = User::factory()->state(['type' => 'organizer'])->create();

        $base = [
            'organizer_id' => $user->id,
            'title' => 'ok',
            'date' => now()->addDay()->toIso8601String(),
            'ticket_price' => '0.00',
            'capacity' => 1,
        ];

        $response = $this->postJson('/api/events', array_merge($base, $override));
        $response->assertUnprocessable()->assertJsonValidationErrors($expectedErrors);
    }

    public static function invalidPayloads(): array
    {
        return [
            'missing title' => [['title' => null], ['title']],
            'negative price' => [['ticket_price' => '-5'], ['ticket_price']],
            'capacity zero' => [['capacity' => 0], ['capacity']],
            'invalid description' => [['description' => -3782], ['description']],
        ];
    }
}
