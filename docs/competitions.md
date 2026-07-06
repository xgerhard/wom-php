# Competitions

← [Back to index](index.md)


- [Search Competitions](#search-competitions)
- [Get Competition Details](#get-competition-details)
- [Get Competition Details CSV](#get-competition-details-csv)
- [Get Top Participants History](#get-top-participants-history)
- [Create Competition](#create-competition)
- [Edit Competition](#edit-competition)
- [Delete Competition](#delete-competition)
- [Add Participants](#add-participants)
- [Remove Participants](#remove-participants)
- [Add Teams](#add-teams)
- [Remove Teams](#remove-teams)
- [Update All Participants](#update-all-participants)

---

## Search Competitions

Search for competitions by title, type, metric or status.

```php
$options = [
    'title' => 'skill of the week',
    'status' => 'ongoing',
];

$competitions = $client->competitions->search($options);

foreach ($competitions as $competition) {
    echo $competition->title . ' (' . $competition->participantCount . ' participants)';
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `title`   | No       | string | Partial competition title |
| `type`    | No       | string | `classic` or `team` |
| `status`  | No       | string | `upcoming`, `ongoing`, `finished` |
| `metric`  | No       | string | Filter by metric |
| `limit`   | No       | int    | Results per page (max 50) |
| `offset`  | No       | int    | Pagination offset |

> Supports pagination via `$client->competitions->paginate('search', $options)`.

---

## Get Competition Details

Fetches the competition's full details, including all participants and their progress.

```php
$id = 1337;
$options = [
    'metric' => 'agility',
];

$competition = $client->competitions->get($id, $options);

echo $competition->title;

foreach ($competition->participations as $participation) {
    echo $participation->player->displayName . ': ' . $participation->progress->gained;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The competition's ID |
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `metric`  | No       | string | View progress in an alternative metric |

---

## Get Competition Details CSV

Fetches the competition's details in CSV format.

```php
$id = 1337;
$options = [
    'table' => 'participants',
];

$csv = $client->competitions->getDetailsCSV($id, $options);

file_put_contents('competition.csv', $csv);
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The competition's ID |
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter  | Required | Type   | Description |
|------------|----------|--------|-------------|
| `metric`   | No       | string | Alternative metric to preview |
| `teamName` | No       | string | Filter by team name |
| `table`    | No       | string | `participants`, `team`, or `teams` |

---

## Get Top Participants History

Fetches the value history for the top 5 participants.

```php
$id = 1337;
$options = [
    'metric' => 'agility',
];

$history = $client->competitions->getTopParticipantsHistory($id, $options);

foreach ($history as $entry) {
    echo $entry->player->displayName;
    foreach ($entry->history as $point) {
        echo $point->date . ': ' . $point->value;
    }
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The competition's ID |
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `metric`  | No       | string | Alternative metric to view |

---

## Create Competition

Creates a new competition and returns the competition details along with a verification code.

```php
$params = [
    'title' => 'Agility SOTW',
    'metric' => 'agility',
    'startsAt' => '2024-01-01T00:00:00.000Z',
    'endsAt' => '2024-01-08T00:00:00.000Z',
    'participants' => ['zezima', 'NotZezima'],
];

$result = $client->competitions->create($params);

echo $result->competition->id;
echo $result->verificationCode;
```

| Parameter | Required | Type  | Description |
|-----------|----------|-------|-------------|
| `$params` | Yes      | array | Competition data (see below) |

**Params**

| Parameter               | Required | Type   | Description |
|-------------------------|----------|--------|-------------|
| `title`                 | Yes      | string | Competition title |
| `metric`                | Yes      | string | The tracked metric |
| `startsAt`              | Yes      | string | Start date |
| `endsAt`                | Yes      | string | End date |
| `groupId`               | No       | int    | Host group ID |
| `groupVerificationCode` | No       | string | Host group verification code |
| `participants`          | No*      | array  | Array of usernames |
| `teams`                 | No*      | array  | Array of `{name, participants}` |

*One of `groupId`, `participants`, or `teams` is required.

---

## Edit Competition

Updates an existing competition's details.

```php
$id = 1337;
$params = [
    'verificationCode' => '123-456-789',
    'title' => 'Updated Title',
    'endsAt' => '2024-01-15T00:00:00.000Z',
];

$competition = $client->competitions->edit($id, $params);
```

| Parameter | Required | Type  | Description |
|-----------|----------|-------|-------------|
| `$id`     | Yes      | int   | The competition's ID |
| `$params` | Yes      | array | Update data (see below) |

**Params**

| Parameter          | Required | Type   | Description |
|--------------------|----------|--------|-------------|
| `verificationCode` | Yes      | string | Competition or host group verification code |
| `title`            | No       | string | New title |
| `metric`           | No       | string | New metric |
| `startsAt`         | No       | string | New start date |
| `endsAt`           | No       | string | New end date |
| `participants`     | No       | array  | New participant list |
| `teams`            | No       | array  | New teams list |

---

## Delete Competition

Permanently deletes a competition. Returns a confirmation message.

```php
$id = 1337;
$verificationCode = '123-456-789';

$message = $client->competitions->delete($id, $verificationCode);

echo $message;
```

| Parameter           | Required | Type   | Description |
|---------------------|----------|--------|-------------|
| `$id`               | Yes      | int    | The competition's ID |
| `$verificationCode` | Yes      | string | The competition's verification code |

---

## Add Participants

Adds participants to a competition, ignoring duplicates.

```php
$id = 1337;
$params = [
    'verificationCode' => '123-456-789',
    'participants' => ['zezima', 'NotZezima'],
];

$result = $client->competitions->addParticipants($id, $params);

echo $result->count;
echo $result->message;
```

| Parameter | Required | Type  | Description |
|-----------|----------|-------|-------------|
| `$id`     | Yes      | int   | The competition's ID |
| `$params` | Yes      | array | Participant data (see below) |

**Params**

| Parameter          | Required | Type   | Description |
|--------------------|----------|--------|-------------|
| `verificationCode` | Yes      | string | The competition's verification code |
| `participants`     | Yes      | array  | Array of usernames |

---

## Remove Participants

Removes participants from a competition.

```php
$id = 1337;
$params = [
    'verificationCode' => '123-456-789',
    'participants' => ['zezima'],
];

$result = $client->competitions->removeParticipants($id, $params);

echo $result->count;
```

| Parameter | Required | Type  | Description |
|-----------|----------|-------|-------------|
| `$id`     | Yes      | int   | The competition's ID |
| `$params` | Yes      | array | Participant data (see below) |

**Params**

| Parameter          | Required | Type   | Description |
|--------------------|----------|--------|-------------|
| `verificationCode` | Yes      | string | The competition's verification code |
| `participants`     | Yes      | array  | Array of usernames to remove |

---

## Add Teams

Adds teams to a team competition, ignoring duplicates.

```php
$id = 1337;
$params = [
    'verificationCode' => '123-456-789',
    'teams' => [
        ['name' => 'Warriors', 'participants' => ['zezima', 'NotZezima']],
        ['name' => 'Soldiers', 'participants' => ['NotNotZezima', 'MaybeZezima']],
    ],
];

$result = $client->competitions->addTeams($id, $params);

echo $result->count;
```

| Parameter | Required | Type  | Description |
|-----------|----------|-------|-------------|
| `$id`     | Yes      | int   | The competition's ID |
| `$params` | Yes      | array | Team data (see below) |

**Params**

| Parameter          | Required | Type   | Description |
|--------------------|----------|--------|-------------|
| `verificationCode` | Yes      | string | The competition's verification code |
| `teams`            | Yes      | array  | Array of `{name (string), participants (array of usernames)}` |

---

## Remove Teams

Removes teams from a team competition.

```php
$id = 1337;
$params = [
    'verificationCode' => '123-456-789',
    'teamNames' => ['Warriors', 'Soldiers'],
];

$result = $client->competitions->removeTeams($id, $params);

echo $result->count;
```

| Parameter | Required | Type  | Description |
|-----------|----------|-------|-------------|
| `$id`     | Yes      | int   | The competition's ID |
| `$params` | Yes      | array | Team data (see below) |

**Params**

| Parameter          | Required | Type   | Description |
|--------------------|----------|--------|-------------|
| `verificationCode` | Yes      | string | The competition's verification code |
| `teamNames`        | Yes      | array  | Array of team names to remove |

---

## Update All Participants

Queues an update for all outdated competition participants.

```php
$id = 1337;
$verificationCode = '123-456-789';

$message = $client->competitions->updateAllParticipants($id, $verificationCode);

echo $message;
```

| Parameter           | Required | Type   | Description |
|---------------------|----------|--------|-------------|
| `$id`               | Yes      | int    | The competition's ID |
| `$verificationCode` | Yes      | string | The competition's verification code |
