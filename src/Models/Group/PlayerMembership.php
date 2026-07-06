<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;

/**
 * @property int $playerId
 * @property int $groupId
 * @property string $role
 * @property string|null $clientSyncJoinedAt
 * @property string $createdAt
 * @property string $updatedAt
 * @property Group $group
 */
class PlayerMembership extends BaseModel
{
    protected array $casts = [
        'group' => Group::class,
    ];
}
