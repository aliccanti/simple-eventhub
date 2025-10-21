<?php

namespace App\Services;

use App\Services\Interfaces\AuthorizerServiceInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\GuzzleException;

class AuthorizerService implements AuthorizerServiceInterface
{
    public function __construct(
        protected Client $client,
    ) {}

    public function authorize(): bool
    {
        try {
            $response = $this->client->request('GET', config('services.auth_api.url'), [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                return false;
            }

            $json = json_decode($response->getBody()->getContents(), true);

            return $json['data']['authorization'] ?? false;
        } catch (GuzzleException $e) {
           /**
            * TODO - log
            */

            return false;
        }
    }
}
