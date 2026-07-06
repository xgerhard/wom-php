# Players

← [Back to index](index.md)


- [Search Players](#search-players)
- [Update Player](#update-player)
- [Assert Player Type](#assert-player-type)
- [Get Player Details](#get-player-details)
- [Get Player Details by ID](#get-player-details-by-id)
- [Get Player Achievements](#get-player-achievements)
- [Get Player Achievement Progress](#get-player-achievement-progress)
- [Get Player Competition Participations](#get-player-competition-participations)
- [Get Player Competition Standings](#get-player-competition-standings)
- [Get Player Group Memberships](#get-player-group-memberships)
- [Get Player Gains](#get-player-gains)
- [Get Player Records](#get-player-records)
- [Get Player Snapshots](#get-player-snapshots)
- [Get Player Snapshots Timeline](#get-player-snapshots-timeline)
- [Get Player Name Changes](#get-player-name-changes)
- [Get Player Archives](#get-player-archives)

---

## Search Players

Search for players by partial username.

```php
$options = [
    'username' => 'zezima',
];

$players = $client->players->search($options);

foreach ($players as $player) {
    echo $player->displayName;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$options` | Yes      | array | Search filters (see below) |

**Options**

| Parameter  | Required | Type   | Description |
|------------|----------|--------|-------------|
| `username` | Yes      | string | Partial username to search for |
| `limit`    | No       | int    | Results per page (max 50) |
| `offset`   | No       | int    | Pagination offset |

> Supports pagination via `$client->players->paginate('search', $options)`.

---

## Update Player

Tracks and updates a player, returning their latest details and snapshot.

```php
$username = 'zezima';

$details = $client->players->update($username);

echo $details->displayName;
echo $details->latestSnapshot->data->skills->overall->level;
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |

---

## Assert Player Type

Checks a player's game mode type and updates it if incorrect.

```php
$username = 'zezima';

$result = $client->players->assertType($username);

echo $result->changed ? 'Type was updated' : 'Type unchanged';
echo $result->player->type;
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |

---

## Get Player Details

Fetches a player's full details including their latest snapshot.

```php
$username = 'zezima';

$player = $client->players->get($username);

echo $player->displayName;
echo $player->ehp;
echo $player->latestSnapshot->data->skills->overall->level;
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |

---

## Get Player Details by ID

Fetches a player's full details by their WOM player ID.

```php
$id = 1337;

$player = $client->players->getById($id);

echo $player->displayName;
```

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `$id`     | Yes      | int  | The player's WOM ID |

---

## Get Player Achievements

Fetches all achievements a player has completed.

```php
$username = 'zezima';

$achievements = $client->players->getAchievements($username);

foreach ($achievements as $achievement) {
    echo $achievement->name;
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |

---

## Get Player Achievement Progress

Fetches a player's progress towards every possible achievement.

```php
$username = 'zezima';

$progress = $client->players->getAchievementProgress($username);

foreach ($progress as $achievement) {
    echo $achievement->name . ': ' . $achievement->relativeProgress . '%';
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |

---

## Get Player Competition Participations

Fetches all competitions a player is or has been participating in.

```php
$username = 'zezima';
$options = [
    'status' => 'ongoing',
];

$participations = $client->players->getCompetitionParticipations($username, $options);

foreach ($participations as $participation) {
    echo $participation->competitionId;
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |
| `$options`  | No       | array  | Optional filters (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `status`  | No       | string | Filter by status: `upcoming`, `ongoing`, `finished` |

---

## Get Player Competition Standings

Fetches a player's standings (rank and progress) in all their competitions.

```php
$username = 'zezima';
$options = [
    'status' => 'ongoing',
];

$standings = $client->players->getCompetitionStandings($username, $options);

foreach ($standings as $standing) {
    echo $standing->rank;
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |
| `$options`  | Yes      | array  | Filters (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `status`  | Yes      | string | Filter by status: `upcoming`, `ongoing`, `finished` |

---

## Get Player Group Memberships

Fetches all groups a player is a member of.

```php
$username = 'zezima';
$options = [
    'limit' => 20,
];

$memberships = $client->players->getGroupMemberships($username, $options);

foreach ($memberships as $membership) {
    echo $membership->group->name . ' - ' . $membership->role;
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |
| `$options`  | No       | array  | Optional filters (see below) |

**Options**

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `limit`   | No       | int  | Results per page (max 50) |
| `offset`  | No       | int  | Pagination offset |

---

## Get Player Gains

Fetches a player's gains for a specific period or date range.

```php
$username = 'zezima';
$options = [
    'period' => 'week',
];

$gains = $client->players->getGains($username, $options);

echo $gains->data->skills->overall->gained;
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |
| `$options`  | Yes      | array  | Period or date range (see below) |

**Options**

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `period`    | Yes*     | string | One of: `five_min`, `day`, `week`, `month`, `year` |
| `startDate` | Yes*     | string | Start of date range |
| `endDate`   | Yes*     | string | End of date range |

*Either `period` or `startDate` + `endDate` is required, not both.

---

## Get Player Records

Fetches a player's personal records, optionally filtered by period and metric.

```php
$username = 'zezima';
$options = [
    'period' => 'week',
    'metric' => 'agility',
];

$records = $client->players->getRecords($username, $options);

foreach ($records as $record) {
    echo $record->metric . ': ' . $record->value;
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |
| `$options`  | No       | array  | Optional filters (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `period`  | No       | string | Filter by period |
| `metric`  | No       | string | Filter by metric |

---

## Get Player Snapshots

Fetches a player's past snapshots for a specific period or date range.

```php
$username = 'zezima';
$options = [
    'period' => 'week',
];

$snapshots = $client->players->getSnapshots($username, $options);

foreach ($snapshots as $snapshot) {
    echo $snapshot->createdAt;
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |
| `$options`  | Yes      | array  | Period or date range (see below) |

**Options**

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `period`    | Yes*     | string | One of: `five_min`, `day`, `week`, `month`, `year` |
| `startDate` | Yes*     | string | Start of date range |
| `endDate`   | Yes*     | string | End of date range |
| `limit`     | No       | int    | Results per page (max 50) |
| `offset`    | No       | int    | Pagination offset |

*Either `period` or `startDate` + `endDate` is required, not both.

---

## Get Player Snapshots Timeline

Returns a chronological value/date series for a specific metric.

```php
$username = 'zezima';
$options = [
    'metric' => 'agility',
    'period' => 'month',
];

$timeline = $client->players->getSnapshotsTimeline($username, $options);

foreach ($timeline as $point) {
    echo $point->date . ': ' . $point->value;
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |
| `$options`  | Yes      | array  | Metric and period or date range (see below) |

**Options**

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `metric`    | Yes      | string | The metric to fetch |
| `period`    | Yes*     | string | One of: `five_min`, `day`, `week`, `month`, `year` |
| `startDate` | Yes*     | string | Start of date range |
| `endDate`   | Yes*     | string | End of date range |

*Either `period` or `startDate` + `endDate` is required, not both.

---

## Get Player Name Changes

Fetches all approved name changes for a player.

```php
$username = 'zezima';

$nameChanges = $client->players->getNameChanges($username);

foreach ($nameChanges as $nameChange) {
    echo $nameChange->oldName . ' → ' . $nameChange->newName;
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |

---

## Get Player Archives

Fetches all previous archived profiles that held this username.

```php
$username = 'zezima';

$archives = $client->players->getArchives($username);

foreach ($archives as $archive) {
    echo $archive->previousUsername;
}
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$username` | Yes      | string | The player's username |
