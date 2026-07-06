# Deltas

← [Back to index](index.md)


- [Get Global Delta Leaderboards](#get-global-delta-leaderboards)

---

## Get Global Delta Leaderboards

Fetches the top gains leaderboard for a specific metric and period.

```php
$options = [
    'period' => 'week',
    'metric' => 'agility',
];

$leaderboard = $client->deltas->getGlobalLeaderboards($options);

foreach ($leaderboard as $entry) {
    echo $entry->player->displayName . ': ' . $entry->gained;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$options` | Yes      | array | Period, metric and optional filters (see below) |

**Options**

| Parameter     | Required | Type   | Description |
|---------------|----------|--------|-------------|
| `period`      | Yes      | string | One of: `five_min`, `day`, `week`, `month`, `year` |
| `metric`      | Yes      | string | The metric to fetch gains for |
| `playerType`  | No       | string | Filter by player type |
| `playerBuild` | No       | string | Filter by player build |
| `country`     | No       | string | Filter by country |
