<?php

namespace App\Services;

use App\Exceptions\ConnectionException;
use App\Services\Interfaces\AuthorizerServiceInterface;
// use App\Support\CircuitBreaker;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthorizerService implements AuthorizerServiceInterface
{
    // private CircuitBreaker $circuitBreaker;

    public function __construct(
        protected Client $client,
    ) {
        // $this->circuitBreaker = new CircuitBreaker;
    }

    public function authorize(): bool|Exception
    {
        Log::info('[authorizer] Inicia processo de autorização');
        for ($attempts = 0; $attempts <= 3; $attempts++) {
            try {
                Log::info('[authorizer] Envia requisição', [
                    'attempts' => $attempts,
                ]);

                $response = $this->client->request('GET', config('services.auth_api.url'), [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'timeout' => 2,
                    'http_errors' => false,
                ]);

                $content = $response->getBody()->getContents();

                Log::info('[authorizer] Requisição realizada com sucesso', [
                    'status' => $response->getStatusCode(),
                    'response' => $content,
                ]);

                $json = json_decode($content, true);

                return $json['data']['authorization'];

            } catch (ConnectException $e) {
                Log::error('[authorizer] Houve um erro ao realizar a requisição', [
                    'message' => $e->getMessage(),
                ]);
                // $this->circuitBreaker->onFailure();
                if ($attempts === 3) {
                    Log::error('[authorizer] Limite de tentativas excedido', [
                        'attempts' => $attempts,
                    ]);
                    throw new ConnectionException; // exception especifica
                }
                sleep(pow(2, $attempts - 1));
            }

        }
    }

    public function processFallback()
    {
        return Str::random(16);
    }
}
