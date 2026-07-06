# Records

← [Back to index](index.md)


- [Get Global Record Leaderboards](#get-global-record-leaderboards)

---

## Get Global Record Leaderboards

Fetches the top records leaderboard for a specific metric and period.

```php
$options = [
    'period' => 'week',
    'metric' => 'agility',
];

$leaderboard = $client->records->getGlobalLeaderboards($options);

foreach ($leaderboard as $entry) {
    echo $entry->player->displayName . ': ' . $entry->value;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$options` | Yes      | array | Period, metric and optional filters (see below) |

**Options**

| Parameter     | Required | Type   | Description |
|---------------|----------|--------|-------------|
| `period`      | Yes      | string | One of: `five_min`, `day`, `week`, `month`, `year` |
| `metric`      | Yes      | string | The metric to fetch records for |
| `playerType`  | No       | string | Filter by player type |
| `playerBuild` | No       | string | Filter by player build |
| `country`     | No       | string | Filter by country |
