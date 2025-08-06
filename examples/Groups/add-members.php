<?php

require('vendor/autoload.php');

try
{
    $client = new WOM\Client()
        ->setApiKey('--API-KEY-HERE--')
        ->setUserAgent('--USER-AGENT-HERE--');

    // replace these
    $groupId = 12345;
    $verificationCode = '111-222-333';

    // https://docs.wiseoldman.net/api/groups/group-endpoints#add-members
    $addMembers = $client->groups->addMembers($groupId, [
        'verificationCode' => $verificationCode,
        'members' => [
            [
                'username' => 'groupmember1',
                'role' => 'member'
            ],
            [
                'username' => 'groupmember2',
                'role' => 'member'
            ]
        ]
    ]);

    echo $addMembers->message;
    
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}