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

    protected function request(string $method, string $uri, array $options = [])
    {
        try {
            $response = $this->client->getHttpClient()->request($method, $uri, $options);
            $x = json_decode((string) $response->getBody());
            // Handle errors here.
            //echo '<pre>';
            //print_r($x);
            return $x;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            return [
                'error' => $e->getMessage(),
                'status' => $response ? $response->getStatusCode() : null,
                'body' => $response ? (string) $response->getBody() : null,
            ];
        }
    }
}
