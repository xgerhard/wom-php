<?php

namespace WOM;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\RequestException;
use WOM\Http\RateLimiter;

class Client
{
    protected GuzzleClient $client;
    protected string $baseUrl = 'https://api.wiseoldman.net/v2/';
    protected ?string $apiKey = null;
    protected ?string $userAgent = null;
    protected array $resources = [];
    public RateLimiter $rateLimiter;

    public function __construct()
    {
        $this->rateLimiter = new RateLimiter(20, 60);
        $this->buildClient();
    }

    public function __get(string $name)
    {
        $map = [
            'players' => Resources\Players::class,
            'records' => Resources\Records::class,
            'deltas' => Resources\Deltas::class
        ];

        if (!isset($map[$name])) {
            throw new \InvalidArgumentException("Unknown resource: $name");
        }

        if (!isset($this->resources[$name])) {
            $this->resources[$name] = new $map[$name]($this);
        }

        return $this->resources[$name];
    }

    public function setApiKey(string $key): self
    {
        $this->apiKey = $key;
        $this->rateLimiter = new RateLimiter(100, 60);
        return $this->buildClient();
    }

    public function setApiBaseUrl(string $url): self
    {
        $this->baseUrl = rtrim($url, '/') . '/';
        return $this->buildClient();
    }

    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;
        return $this->buildClient();
    }

    protected function buildClient(): self
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        if ($this->apiKey) {
            $headers['X-API-Key'] = $this->apiKey;
        }

        if ($this->userAgent) {
            $headers['User-Agent'] = $this->userAgent;
        }

        $this->client = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'timeout' => 10.0,
            'verify' => false,
            RequestOptions::HEADERS => $headers,
        ]);

        return $this;
    }

    public function getHttpClient(): GuzzleClient
    {
        return $this->client;
    }
}
