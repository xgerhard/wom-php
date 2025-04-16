<?php

namespace WOM\Http;

class RateLimiter
{
    private array $timestamps = [];

    public function __construct(
        private int $limit = 20,
        private int $windowSeconds = 60
    ) {}

    public function handle(int $retryCount = 0): void
    {
        $now = time();
    
        $this->timestamps = array_filter(
            $this->timestamps,
            fn($ts) => $ts > $now - $this->windowSeconds
        );
    
        $count = count($this->timestamps);
    
        if ($count >= $this->limit) {
            $oldest = min($this->timestamps);
            $wait = ($oldest + $this->windowSeconds) - $now;
    
            if ($wait > 0) {
                sleep($wait);
                $this->timestamps[] = time(); 
                return;
            }
        }
    
        if ($retryCount > 0) {
            $fallback = ceil($this->windowSeconds / $this->limit);
            sleep($fallback);
        }
    }
}