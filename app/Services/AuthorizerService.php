<?php

namespace App\Services;

use App\Exceptions\ConnectionException;
use App\Services\Interfaces\AuthorizerServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class AuthorizerService implements AuthorizerServiceInterface
{
    public function __construct(
        protected Client $client,
        protected LoggerInterface $logger
    ) {}

    public function authorize(): bool
    {
        $maxAttempts = 3;
        $this->logger->info('Inicia processo de autorização');
        for ($attempts = 1; $attempts <= $maxAttempts; $attempts++) {
            try {
                $this->logger->info('Enviado requisição de autorização', [
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

                $this->logger->info('Requisição realizada com sucesso', [
                    'status' => $response->getStatusCode(),
                    'response' => $content,
                ]);

                $json = json_decode($content, true);

                return $json['data']['authorization'];

            } catch (ConnectException $e) {
                 $this->logger->error('Houve um erro ao realizar a requisição', [
                    'message' => $e->getMessage(),
                ]);
                if ($attempts === $maxAttempts) {
                    Log::error('[authorizer] Limite de tentativas excedido', [
                        'attempts' => $attempts,
                    ]);
                    throw new ConnectionException();
                }
                sleep(pow(2, $attempts - 1));
                return false;
            }

        }
    }
}
