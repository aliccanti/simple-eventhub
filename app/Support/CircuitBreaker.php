<?php

class CircuitBreaker
{
    public function __construct(
        private string $state = 'closed',
        private int $failureThreshold = 5,
        private int $openSeconds = 30,
        private int $failureCount = 0,
        private ?int $openedAt = null
    ) {}

    public function allowRequest(): bool
    {
        if ($this->state === 'open') {
            if (time() - $this->openedAt >= $this->openSeconds) {
                $this->state = 'half';

                return true;
            }

            return false;
        }

        return true;
    }

    public function onSuccess(): void
    {
        $this->failureCount = 0;
        $this->state = 'closed';

    }

    public function onFailure(): void
    {
        $this->failureCount++;
        $this->state = $this->failureCount >= $this->failureThreshold ? 'open' : 'half';
    }

    public function getState(): string
    {
        return $this->state;
    }
}
