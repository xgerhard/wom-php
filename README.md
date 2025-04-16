# wom-php

**wom-php** is a PHP wrapper for the [Wise Old Man API](https://docs.wiseoldman.net/).  
Wise Old Man is an open source Old School RuneScape player progress tracker: [https://wiseoldman.net](https://wiseoldman.net).

## Work in Progress
⚠️ This package is still in early development (pre-1.0).

## Usage
```
composer require xgerhard/wom-php
```

```php
use WOM\Client;

$client = new Client();
$player = $client->players->get('gerhardoh');
```

## Documentation & Examples

See [`docs/examples.md`](docs/examples.md) for usage examples.

## Supported Endpoints

| Endpoint        | Status         |
|----------------|----------------|
| Players         | ✅ Implemented |
| Groups          | ❌ Not yet     |
| Competitions    | ❌ Not yet     |
| Records         | ❌ Not yet     |
| Deltas          | ❌ Not yet     |
| Name Changes    | ❌ Not yet     |
| Efficiency      | ❌ Not yet     |

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