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

    public function paginate(string $method, array $params = [], int $limit = 50, bool $lazy = false, ?int $maxPages = null): array|\Generator
    {
        $fetch = function () use ($method, $params, $limit, $maxPages): \Generator {
            $offset = 0;
            $page = 0;
            do {
                $results = $this->$method(array_merge($params, ['limit' => $limit, 'offset' => $offset]));
                foreach ($results as $item) {
                    yield $item;
                }
                $offset += $limit;
                $page++;
            } while (count($results) === $limit && ($maxPages === null || $page < $maxPages));
        };

        if ($lazy) {
            return $fetch();
        }

        return iterator_to_array($fetch(), false);
    }

    protected function mapToModels(array $items, string $modelClass): array
    {
        return array_map(fn($item) => new $modelClass($item), $items);
    }

    protected function validateTimeParams(array $params): void
    {
        $hasPeriod = isset($params['period']);
        $hasStart = isset($params['startDate']);
        $hasEnd = isset($params['endDate']);
    
        if (!$hasPeriod && !($hasStart && $hasEnd)) {
            throw new \InvalidArgumentException('You must provide either "period" or both "startDate" and "endDate".');
        }
    
        if ($hasPeriod && ($hasStart || $hasEnd)) {
            throw new \InvalidArgumentException('Use either "period" or "startDate" and "endDate", not both.');
        }
    
        if ($hasStart xor $hasEnd) {
            throw new \InvalidArgumentException('You must provide both "startDate" and "endDate" together.');
        }
    }

    protected function request(string $method, string $uri, array $options = [])
    {
        try {
            $this->client->rateLimiter->handle();

            $response = $this->client->getHttpClient()->request($method, $uri, $options);

            $limit = (int) $response->getHeaderLine('RateLimit-Limit');
            $remaining = (int) $response->getHeaderLine('RateLimit-Remaining');
            $reset = (int) $response->getHeaderLine('RateLimit-Reset');

            if ($limit > 0) {
                $this->client->rateLimiter->updateFromHeaders($limit, $remaining, $reset);
            }

            $isJson = str_contains($response->getHeaderLine('Content-Type'), 'application/json');

            return $isJson ? json_decode((string) $response->getBody()) : (string) $response->getBody();
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if ($e->getCode() === 429 && $response) {
                $retryAfter = (int) $response->getHeaderLine('Retry-After');
                $this->client->rateLimiter->retryAfter($retryAfter);
                return $this->request($method, $uri, $options);
            }

            if (!$response) {
                $errorMessage = 'No response received from WiseOldMan API.';
            } else {
                $isJson = str_contains($response->getHeaderLine('Content-Type'), 'application/json');
                $responseBody = $isJson ? json_decode((string) $response->getBody()) : (string) $response->getBody();
                $errorMessage = isset($responseBody->message) ? $responseBody->message : 'Unknown error received from WiseOldMan API';
                $errorMessage .= ' [Status code: ' . $response->getStatusCode() . ']';
            }

            throw new \Exception($errorMessage);
        }
    }
}
