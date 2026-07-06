# Groups

← [Back to index](index.md)


- [Search Groups](#search-groups)
- [Get Group Details](#get-group-details)
- [Create Group](#create-group)
- [Edit Group](#edit-group)
- [Delete Group](#delete-group)
- [Add Members](#add-members)
- [Remove Members](#remove-members)
- [Change Member Role](#change-member-role)
- [Update All Members](#update-all-members)
- [Get Group Competitions](#get-group-competitions)
- [Get Group Gains](#get-group-gains)
- [Get Group Bulk Gains](#get-group-bulk-gains)
- [Get Group Achievements](#get-group-achievements)
- [Get Group Records](#get-group-records)
- [Get Group Hiscores](#get-group-hiscores)
- [Get Group Bulk Hiscores](#get-group-bulk-hiscores)
- [Get Group Name Changes](#get-group-name-changes)
- [Get Group Statistics](#get-group-statistics)
- [Get Group Activity](#get-group-activity)
- [Get Group Members CSV](#get-group-members-csv)

---

## Search Groups

Search for groups by partial name.

```php
$options = [
    'name' => 'iron',
];

$groups = $client->groups->search($options);

foreach ($groups as $group) {
    echo $group->name . ' (' . $group->memberCount . ' members)';
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `name`    | No       | string | Partial group name to search for |
| `limit`   | No       | int    | Results per page (max 50) |
| `offset`  | No       | int    | Pagination offset |

> Supports pagination via `$client->groups->paginate('search', $options)`.

---

## Get Group Details

Fetches a group's full details including its members and social links.

```php
$id = 1337;

$group = $client->groups->get($id);

echo $group->name;
echo $group->memberCount;

foreach ($group->memberships as $membership) {
    echo $membership->player->displayName . ' - ' . $membership->role;
}
```

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `$id`     | Yes      | int  | The group's ID |

---

## Create Group

Creates a new group and returns the group details along with a verification code.

```php
$params = [
    'name' => 'My Group',
    'members' => [
        ['username' => 'zezima', 'role' => 'leader'],
        ['username' => 'NotZezima', 'role' => 'member'],
    ],
];

$result = $client->groups->create($params);

echo $result->group->id;
echo $result->verificationCode;
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$params`  | Yes      | array | Group data (see below) |

**Params**

| Parameter     | Required | Type   | Description |
|---------------|----------|--------|-------------|
| `name`        | Yes      | string | The group's name |
| `members`     | Yes      | array  | Array of `{username, role}` |
| `clanChat`    | No       | string | Clan chat name |
| `description` | No       | string | Group description |
| `homeworld`   | No       | int    | Home world number |

---

## Edit Group

Updates an existing group's details.

```php
$id = 1337;
$params = [
    'verificationCode' => '123-456-789',
    'description' => 'Updated description',
];

$group = $client->groups->edit($id, $params);
```

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `$id`     | Yes      | int    | The group's ID |
| `$params` | Yes      | array  | Update data (see below) |

**Params**

| Parameter          | Required | Type   | Description |
|--------------------|----------|--------|-------------|
| `verificationCode` | Yes      | string | The group's verification code |
| `name`             | No       | string | New group name |
| `description`      | No       | string | New description |
| `clanChat`         | No       | string | New clan chat name |
| `homeworld`        | No       | int    | New home world |
| `members`          | No       | array  | New member list `{username, role}` |

---

## Delete Group

Permanently deletes a group. Returns a confirmation message.

```php
$id = 1337;
$verificationCode = '123-456-789';

$message = $client->groups->delete($id, $verificationCode);

echo $message;
```

| Parameter           | Required | Type   | Description |
|---------------------|----------|--------|-------------|
| `$id`               | Yes      | int    | The group's ID |
| `$verificationCode` | Yes      | string | The group's verification code |

---

## Add Members

Adds new members to an existing group.

```php
$id = 1337;
$params = [
    'verificationCode' => '123-456-789',
    'members' => [
        ['username' => 'zezima', 'role' => 'member'],
    ],
];

$message = $client->groups->addMembers($id, $params);
```

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `$id`     | Yes      | int    | The group's ID |
| `$params` | Yes      | array  | Member data (see below) |

**Params**

| Parameter          | Required | Type   | Description |
|--------------------|----------|--------|-------------|
| `verificationCode` | Yes      | string | The group's verification code |
| `members`          | Yes      | array  | Array of `{username, role}` |

---

## Remove Members

Removes members from an existing group.

```php
$id = 1337;
$params = [
    'verificationCode' => '123-456-789',
    'members' => ['zezima', 'NotZezima'],
];

$message = $client->groups->removeMembers($id, $params);
```

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `$id`     | Yes      | int    | The group's ID |
| `$params` | Yes      | array  | Member data (see below) |

**Params**

| Parameter          | Required | Type   | Description |
|--------------------|----------|--------|-------------|
| `verificationCode` | Yes      | string | The group's verification code |
| `members`          | Yes      | array  | Array of usernames to remove |

---

## Change Member Role

Changes the role of an existing group member.

```php
$id = 1337;
$params = [
    'verificationCode' => '123-456-789',
    'username' => 'zezima',
    'role' => 'leader',
];

$membership = $client->groups->changeRole($id, $params);

echo $membership->role;
```

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `$id`     | Yes      | int    | The group's ID |
| `$params` | Yes      | array  | Role data (see below) |

**Params**

| Parameter          | Required | Type   | Description |
|--------------------|----------|--------|-------------|
| `verificationCode` | Yes      | string | The group's verification code |
| `username`         | Yes      | string | The member's username |
| `role`             | Yes      | string | The new role |

---

## Update All Members

Queues an update for all outdated group members.

```php
$id = 1337;
$verificationCode = '123-456-789';

$message = $client->groups->updateAll($id, $verificationCode);

echo $message;
```

| Parameter           | Required | Type   | Description |
|---------------------|----------|--------|-------------|
| `$id`               | Yes      | int    | The group's ID |
| `$verificationCode` | Yes      | string | The group's verification code |

---

## Get Group Competitions

Fetches all competitions hosted by a group.

```php
$id = 1337;
$options = [
    'limit' => 20,
];

$competitions = $client->groups->getCompetitions($id, $options);

foreach ($competitions as $competition) {
    echo $competition->title;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The group's ID |
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `limit`   | No       | int  | Results per page (max 50) |
| `offset`  | No       | int  | Pagination offset |

---

## Get Group Gains

Fetches the top gains for a group's members for a specific metric and period.

```php
$id = 1337;
$options = [
    'metric' => 'agility',
    'period' => 'week',
];

$gains = $client->groups->getGains($id, $options);

foreach ($gains as $entry) {
    echo $entry->player->displayName . ': ' . $entry->data->gained;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The group's ID |
| `$options` | Yes      | array | Metric and period or date range (see below) |

**Options**

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `metric`    | Yes      | string | The metric to fetch gains for |
| `period`    | Yes*     | string | One of: `five_min`, `day`, `week`, `month`, `year` |
| `startDate` | Yes*     | string | Start of date range |
| `endDate`   | Yes*     | string | End of date range |

*Either `period` or `startDate` + `endDate` is required, not both.

---

## Get Group Bulk Gains

Fetches gains for every metric for all group members.

```php
$id = 1337;
$options = [
    'period' => 'week',
];

$bulkGains = $client->groups->getBulkGains($id, $options);

foreach ($bulkGains as $entry) {
    echo $entry->player->displayName;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The group's ID |
| `$options` | Yes      | array | Period or date range (see below) |

**Options**

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `period`    | Yes*     | string | One of: `five_min`, `day`, `week`, `month`, `year` |
| `startDate` | Yes*     | string | Start of date range |
| `endDate`   | Yes*     | string | End of date range |

*Either `period` or `startDate` + `endDate` is required, not both.

---

## Get Group Achievements

Fetches the group's latest achievements across all members.

```php
$id = 1337;
$options = [
    'limit' => 20,
];

$achievements = $client->groups->getAchievements($id, $options);

foreach ($achievements as $achievement) {
    echo $achievement->player->displayName . ': ' . $achievement->name;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The group's ID |
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `limit`   | No       | int  | Results per page (max 50) |
| `offset`  | No       | int  | Pagination offset |

---

## Get Group Records

Fetches the group's record leaderboard for a specific metric and period.

```php
$id = 1337;
$options = [
    'period' => 'week',
    'metric' => 'agility',
];

$records = $client->groups->getRecords($id, $options);

foreach ($records as $record) {
    echo $record->player->displayName . ': ' . $record->value;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The group's ID |
| `$options` | Yes      | array | Period and metric (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `period`  | Yes      | string | The time period |
| `metric`  | Yes      | string | The metric |
| `limit`   | No       | int    | Results per page (max 50) |
| `offset`  | No       | int    | Pagination offset |

---

## Get Group Hiscores

Fetches the group's hiscores for a specific metric, ranked by experience/kills/score.

```php
$id = 1337;
$options = [
    'metric' => 'agility',
];

$hiscores = $client->groups->getHiscores($id, $options);

foreach ($hiscores as $entry) {
    echo $entry->player->displayName . ': ' . $entry->data->experience;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The group's ID |
| `$options` | Yes      | array | Metric (see below) |

**Options**

| Parameter | Required | Type   | Description |
|-----------|----------|--------|-------------|
| `metric`  | Yes      | string | The metric to fetch hiscores for |

---

## Get Group Bulk Hiscores

Fetches every group member's full snapshot in a single request.

```php
$id = 1337;

$hiscores = $client->groups->getBulkHiscores($id);

foreach ($hiscores as $entry) {
    echo $entry->player->displayName;
    echo $entry->data->data->skills->overall->level;
}
```

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `$id`     | Yes      | int  | The group's ID |

---

## Get Group Name Changes

Fetches the group's latest name changes.

```php
$id = 1337;
$options = [
    'limit' => 20,
];

$nameChanges = $client->groups->getNameChanges($id, $options);

foreach ($nameChanges as $nameChange) {
    echo $nameChange->oldName . ' → ' . $nameChange->newName;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The group's ID |
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `limit`   | No       | int  | Results per page (max 50) |
| `offset`  | No       | int  | Pagination offset |

---

## Get Group Statistics

Fetches general statistics about a group, including maxed counts and metric leaders.

```php
$id = 1337;

$stats = $client->groups->getStatistics($id);

echo $stats->maxedCombatCount;
echo $stats->maxedTotalCount;
echo $stats->averageStats->data->skills->overall->level;
```

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `$id`     | Yes      | int  | The group's ID |

---

## Get Group Activity

Fetches recent activity events for a group (joins, leaves, role changes).

```php
$id = 1337;
$options = [
    'limit' => 20,
];

$activity = $client->groups->getActivity($id, $options);

foreach ($activity as $entry) {
    echo $entry->player->displayName . ' ' . $entry->type;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$id`      | Yes      | int   | The group's ID |
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `limit`   | No       | int  | Results per page (max 50) |
| `offset`  | No       | int  | Pagination offset |

---

## Get Group Members CSV

Returns the group's member list as a CSV string.

```php
$id = 1337;

$csv = $client->groups->getMembersCSV($id);

file_put_contents('members.csv', $csv);
```

| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| `$id`     | Yes      | int  | The group's ID |
