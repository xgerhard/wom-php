# Pagination

← [Back to index](index.md)

- [Basic Usage](#basic-usage)
- [Lazy Pagination](#lazy-pagination)
- [Parameters](#parameters)

---

## Basic Usage

Endpoints that support pagination can be iterated automatically using `paginate()`:

```php
$groups = $client->groups->paginate('search', ['name' => 'iron']);

foreach ($groups as $group) {
    echo $group->name;
}
```

By default, `paginate()` fetches 50 results per page and returns a flat array with all results.

Limit the number of pages to avoid fetching too many results:

```php
$groups = $client->groups->paginate('search', ['name' => 'iron'], maxPages: 2);
```

---

## Lazy Pagination

Use `lazy: true` to return a generator instead of a flat array. This is memory efficient for large datasets as it fetches one page at a time as you iterate:

```php
foreach ($client->players->paginate('search', ['username' => 'zezima'], lazy: true) as $player) {
    echo $player->displayName;
}
```

You can also break early without fetching unnecessary pages:

```php
foreach ($client->groups->paginate('search', ['name' => 'iron'], lazy: true) as $group) {
    if ($group->memberCount > 100) {
        break;
    }
}
```

---

## Parameters

| Parameter   | Default | Description |
|-------------|---------|-------------|
| `$method`   |         | The resource method to paginate |
| `$params`   | `[]`    | Query parameters passed to the method |
| `$limit`    | `50`    | Results per page (API max is 50) |
| `$lazy`     | `false` | Return a generator instead of a flat array |
| `$maxPages` | `null`  | Maximum number of pages to fetch (null = all) |
