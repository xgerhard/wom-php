# Client

← [Back to index](index.md)


- [Basic Setup](#basic-setup)
- [API Key](#api-key)
- [User Agent](#user-agent)
- [API Base URL](#custom-base-url)
- [Resources](#resources)

---

## Basic Setup

```php
use WOM\Client;

$client = new Client();
```

Without an API key, the rate limit is **20 requests per minute**.

---

## API Key

Setting an API key increases the rate limit to **100 requests per minute**.

```php
$client = new Client();
$client->setApiKey('your-api-key');
```

Methods can be chained:

```php
$client = (new Client())
    ->setApiKey('your-api-key')
    ->setUserAgent('MyApp - DiscordNameHere');
```

---

## User Agent

It is recommended to set a user agent so the WOM team can identify your application.

```php
$client->setUserAgent('MyApp - DiscordNameHere');
```

---

## API Base URL

Only required if hosting your own WOM API instance.

```php
$client->setApiBaseUrl('https://my-wom-instance.com/api/v2');
```

---

## Resources

All API resources are accessible as properties on the client:

| Property | Description |
|----------|-------------|
| `$client->players` | [Players](players.md) |
| `$client->groups` | [Groups](groups.md) |
| `$client->competitions` | [Competitions](competitions.md) |
| `$client->deltas` | [Deltas](deltas.md) |
| `$client->records` | [Records](records.md) |
| `$client->efficiency` | [Efficiency](efficiency.md) |
| `$client->namechanges` | [Name Changes](name-changes.md) |
