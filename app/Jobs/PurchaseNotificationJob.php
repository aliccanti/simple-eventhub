<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use GuzzleHttp\Client;

class PurchaseNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $email,
        public string $eventName
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(Client $client): void
    {
         $client->request('POST', config('services.notification_api.url'), [
                'json' => [
                    'to' => $this->email,
                    'subject' => 'Inscrição realizada no evento ' . '$this->eventName',
                    'message' => "Sua inscrição no evento {$this->eventName} foi realizada com sucesso.",
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);
    }
}
