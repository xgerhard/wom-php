<?php

namespace WOM\Resources;

use GuzzleHttp\Exception\RequestException;
use WOM\Client;

abstract class BaseResource
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function mapToModels(array $items, string $modelClass): array
    {
        return array_map(fn($item) => new $modelClass($item), $items);
    }

    protected function request(string $method, string $uri, array $options = [], $retryCount = 0)
    {
        try {
            $this->client->rateLimiter->handle($retryCount);

            $response = $this->client->getHttpClient()->request($method, $uri, $options);
            return json_decode((string) $response->getBody());
        } catch (RequestException $e) {

            if ($e->getCode() === 429 && $retryCount < 3) {
                return $this->request($method, $uri, $options, $retryCount + 1);
            }

            $response = $e->getResponse();
            $x = [
                'error' => $e->getMessage(),
                'status' => $response ? $response->getStatusCode() : null,
                'body' => $response ? (string) $response->getBody() : null,
            ];
            echo '<pre>';
            print_r($x);
            die;
        }
    }
}
