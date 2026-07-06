<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string $clanChat
 * @property string|null $description
 * @property int|null $homeworld
 * @property bool $verified
 * @property bool $patron
 * @property string|null $profileImage
 * @property string|null $bannerImage
 * @property int $score
 * @property string $createdAt
 * @property string $updatedAt
 * @property int $memberCount
 * @property SocialLinks $socialLinks
 * @property Membership[] $memberships
 */
class Details extends BaseModel
{
    protected array $casts = [
        'socialLinks' => SocialLinks::class,
        'memberships' => [
            'type' => Membership::class,
            'many' => true,
        ],
    ];
}
