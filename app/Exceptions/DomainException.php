<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class DomainException extends Exception
{
    abstract public function status(): int;

    abstract public function type(): string;

    abstract public function title(): string;

    public function detail(): string
    {
        return $this->getMessage();
    }

    public function render(): JsonResponse
    {
        $exception = [
            'type' => $this->type(),
            'title' => $this->title(),
            'status' => $this->status(),
            'detail' => $this->detail(),
        ];

        return response()
            ->json($exception, $this->status())
            ->header('Content-Type', 'application/problem+json');

    }

    public function report(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $request = request();

        $context = [
            'error' => [
                'type' => $this->type(),
                'title' => $this->title(),
                'status' => $this->status(),
                'detail' => $this->detail(),
            ],
            'request' => [
                'method' => $request?->getMethod(),
                'path' => $request?->path(),
            ],
        ];

        Log::warning(json_encode($context));

    }
}
