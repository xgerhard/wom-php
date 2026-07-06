# Name Changes

← [Back to index](index.md)


- [Search Name Changes](#search-name-changes)
- [Submit Name Change](#submit-name-change)

---

## Search Name Changes

Search for name changes by username and/or status.

```php
$options = [
    'username' => 'zezima',
    'status' => 'approved',
];

$nameChanges = $client->nameChanges->search($options);

foreach ($nameChanges as $nameChange) {
    echo $nameChange->oldName . ' → ' . $nameChange->newName;
}
```

| Parameter  | Required | Type  | Description |
|------------|----------|-------|-------------|
| `$options` | No       | array | Optional filters (see below) |

**Options**

| Parameter  | Required | Type   | Description |
|------------|----------|--------|-------------|
| `username` | No       | string | Partial username to search for |
| `status`   | No       | string | Filter by status: `pending`, `approved`, `denied` |
| `limit`    | No       | int    | Results per page (max 50) |
| `offset`   | No       | int    | Pagination offset |

> Supports pagination via `$client->nameChanges->paginate('search', $options)`.

---

## Submit Name Change

Submit a name change request between two usernames.

```php
$oldName = 'oldUsername';
$newName = 'newUsername';

$nameChange = $client->nameChanges->submit($oldName, $newName);

echo $nameChange->status; // pending
```

| Parameter   | Required | Type   | Description |
|-------------|----------|--------|-------------|
| `$oldName`  | Yes      | string | The player's previous username |
| `$newName`  | Yes      | string | The player's new username |
