# wom-php

**wom-php** is a PHP wrapper for the [Wise Old Man API](https://docs.wiseoldman.net/).  
Wise Old Man is an open source Old School RuneScape player progress tracker: [wiseoldman.net](https://wiseoldman.net).

## Work in Progress
⚠️ This package is still in development, but is stable and ready to use.

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
More helper methods will be added in future releases — including support for custom formatting.

## Documentation & Examples

See [`docs/examples.md`](docs/examples.md) for usage examples.

## Supported Endpoints

| Endpoint        | Status         |
|----------------|----------------|
| Players         | ✅ Implemented |
| Groups          | ✅ Implemented |
| Competitions    | ✅ Implemented |
| Records         | ✅ Implemented |
| Deltas          | ✅ Implemented |
| Name Changes    | ✅ Implemented |
| Efficiency      | ✅ Implemented |

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
php vendor/bin/phpunit
```

Or run a specific test: `php vendor/bin/phpunit --filter testCanFetchPlayerDetails`

Feel free to add tests when contributing new features or fixes!

## License
wom-php is licensed under the MIT License.