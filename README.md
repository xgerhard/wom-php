# wom-php

**wom-php** is a PHP wrapper for the [Wise Old Man API](https://docs.wiseoldman.net/).  
Wise Old Man is an open source Old School RuneScape player progress tracker: [wiseoldman.net](https://wiseoldman.net).

## Bugs / Feature requests

Found a bug or want to request a feature? [Open an issue](https://github.com/xgerhard/wom-php/issues).


## Usage
```
composer require xgerhard/wom-php
```

```php
use WOM\Client;

$client = new Client();
$player = $client->players->get('zezima');

echo $player->displayName; // Zezima
```

All model properties are directly accessible via object-style access:
```php
$level = $player->latestSnapshot->data->skills->overall->level;
```
Models also include helpful formatting methods for display:
```php
echo $boss->formatMetric(); // Chambers Of Xeric
echo $boss->formatRank(); // 13.37k
echo $skill->formatExperience(); // 13.03m
```
More helper methods will be added in future releases, including support for custom formatting.

## Documentation

See [`docs/index.md`](docs/index.md) for the full documentation.

| Resource | Description |
|----------|-------------|
| [Players](docs/players.md) | Search, track and fetch player data |
| [Groups](docs/groups.md) | Manage and fetch group data |
| [Competitions](docs/competitions.md) | Manage and fetch competition data |
| [Deltas](docs/deltas.md) | Fetch delta leaderboards |
| [Records](docs/records.md) | Fetch record leaderboards |
| [Efficiency](docs/efficiency.md) | Fetch efficiency rates and leaderboards |
| [Name Changes](docs/name-changes.md) | Search and submit name changes |

## Contributing
Feel free to explore, contribute, or play around with this wrapper.

To set up a local development environment for the package, follow these steps:

1. **Clone the repository:**

```
git clone https://github.com/xgerhard/wom-php.git
```

2. **Create a new folder for your test project**, and add a `composer.json` file pointing to your local clone:

```
{
  "repositories": [
    {
      "type": "path",
      "url": "../path/to/local/wom-php",
      "options": {
        "symlink": true
      }
    }
  ],
  "require": {
    "xgerhard/wom-php": "dev-main"
  }
}
```
3. **Install the local package:**

```
composer require xgerhard/wom-php:dev-main
```

4. Your project will now use your local `wom-php` version and any changes you make will be reflected immediately.


## Running Tests
To run the test suite:

1. From your cloned `wom-php` folder, install dependencies:
```
composer install
```

2. Then run the tests:
```
php vendor/bin/phpunit --testdox
```

Or run a specific test: `php vendor/bin/phpunit --filter testCanFetchPlayerDetails`

Feel free to add tests when contributing new features or fixes!

## License
wom-php is licensed under the MIT License.