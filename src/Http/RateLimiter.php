<?php

namespace WOM\Http;

class RateLimiter
{
    private int $remaining = PHP_INT_MAX;
    private int $reset = 0;

    public function updateFromHeaders(int $limit, int $remaining, int $reset): void
    {
        $this->remaining = $remaining;
        $this->reset = $reset;
    }

    public function handle(): void
    {
        if ($this->remaining === 0) {
            sleep(max(1, $this->reset));
        }
    }

    public function retryAfter(int $seconds): void
    {
        sleep(max(1, $seconds));
    }
}
