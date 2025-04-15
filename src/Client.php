<?php

namespace WOM;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\RequestException;


class Client
{
    protected GuzzleClient $client;
    protected string $baseUrl = 'https://api.wiseoldman.net/v2/';
    protected ?string $apiKey = null;
    protected ?string $userAgent = null;
    protected array $resources = [];

    public function __construct()
    {
        $this->buildClient();
    }

    public function __get(string $name)
    {
        $map = [
            'players' => Resources\Players::class,
            'groups' => Resources\Groups::class
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
            'timeout' => 5.0,
            RequestOptions::HEADERS => $headers,
        ]);

        return $this;
    }

    public function getHttpClient(): \GuzzleHttp\Client
    {
        return $this->client;
    }

    public function testConnection(): string
    {
        try {
            $response = $this->client->get('groups', [
                'query' => ['name' => 'The']
            ]);
            echo '<pre>';
            print_r(json_decode($response->getBody()->getContents()));
            echo $response->getStatusCode();
            echo (string) $response->getBody();
        
        } catch (RequestException $e) {
            echo 'FOUT: ' . $e->getCode() . PHP_EOL;
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
