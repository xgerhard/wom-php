<?php

require('vendor/autoload.php');

try
{
    $client = new WOM\Client()
        ->setApiKey('--API-KEY-HERE--')
        ->setUserAgent('--USER-AGENT-HERE--');

    // https://docs.wiseoldman.net/api/groups/group-endpoints#create-group
    $group = $client->groups->create([
        'name' => 'My awesome group',
        'clanChat' => 'myawesomecc', // optional
        'description' => 'My awesome group!', // optional
        'homeworld' => 420, // optional
        'members' => [
            [
                'username' => 'myusername',
                'role' => 'owner' // owner, member, administrator, etc.
            ]
        ]
    ]);

    // Important: store these variables, you will need the verification code and group id to manage your group.
    $verificationCode = $group->verificationCode;
    $groupId = $group->group->id;
    
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}