# Getting Started

← [Back to index](index.md)


- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Error Handling](#error-handling)
- [Next Steps](#next-steps)

---

## Installation

Install the package via Composer:

```bash
composer require xgerhard/wom-php
```

---

## Basic Usage

Require the Composer autoloader and create a client:

```php
require 'vendor/autoload.php';

use WOM\Client;

$client = new Client();

$player = $client->players->get('zezima');

echo $player->displayName; // Zezima
echo $player->ehp;         // 1234.56
```

All model properties are directly accessible via object-style access:

```php
$level = $player->latestSnapshot->data->skills->overall->level;
```

---

## Error Handling

Wrap your calls in a try/catch to handle API errors gracefully:

```php
require 'vendor/autoload.php';

use WOM\Client;

$client = new Client();

try {
    $player = $client->players->get('zezima');
    echo $player->displayName;
} catch (\InvalidArgumentException $e) {
    // Thrown when required parameters are missing or invalid
    echo 'Invalid input: ' . $e->getMessage();
} catch (\Exception $e) {
    // Thrown when the API returns an error (404, 500, etc.)
    echo 'API error: ' . $e->getMessage();
}
```

---

## Next Steps

- [Client](client.md) - configure API key, user agent, rate limiting
- [Players](players.md) - search, track and fetch player data
- [Groups](groups.md) - manage and fetch group data
- [Competitions](competitions.md) - manage and fetch competition data
- [Deltas](deltas.md) - fetch delta leaderboards
- [Records](records.md) - fetch record leaderboards
- [Efficiency](efficiency.md) - fetch efficiency rates and leaderboards
- [Name Changes](name-changes.md) - search and submit name changes
