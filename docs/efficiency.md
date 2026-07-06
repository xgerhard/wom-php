# Efficiency

← [Back to index](index.md)


- [Get Efficiency Rates](#get-efficiency-rates)
- [Get Global Efficiency Leaderboards](#get-global-efficiency-leaderboards)

---

## Get Efficiency Rates

Fetches the efficiency rates (EHP/EHB) for a specific algorithm type.

```php
$options = [
    'type' => 'main',
    'metric' => 'ehb',
];

$rates = $client->efficiency->getRates($options);

foreach ($rates as $rate) {
    echo $rate->boss . ': ' . $rate->rate . ' kc/hr';
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$options` | Yes      | array | Type and metric (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `type`    | Yes      | string | One of: `main`, `ironman`, `ultimate`, `lvl3`, `f2p`, `f2p_lvl3`, `f2p_ironman`, `f2p_lvl3_ironman` |
| `metric`  | Yes      | string | `ehp` or `ehb` |

---

## Get Global Efficiency Leaderboards

Fetches the top players ranked by EHP, EHB, or combined.

```php
$options = [
    'metric' => 'ehp',
];

$leaderboard = $client->efficiency->getGlobalLeaderboards($options);

foreach ($leaderboard as $player) {
    echo $player->displayName . ': ' . $player->ehp . ' EHP';
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$options` | Yes      | array | Metric and optional filters (see below) |

**Options**

| Parameter     | Required | Type   | Description |
|---------------|----------|--------|-------------|
| `metric`      | Yes      | string | `ehp`, `ehb`, or `ehp+ehb` |
| `playerType`  | No       | string | Filter by player type |
| `playerBuild` | No       | string | Filter by player build |
| `country`     | No       | string | Filter by country |
| `limit`       | No       | int    | Results per page (max 50) |
| `offset`      | No       | int    | Pagination offset |

> Supports pagination via `$client->efficiency->paginate('getGlobalLeaderboards', $options)`.
