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

    // https://docs.wiseoldman.net/api/groups/group-endpoints#remove-members
    $removeMembers = $client->groups->removeMembers($groupId, [
        'verificationCode' => $verificationCode,
        'members' => [
            'groupmember1',
            'groupmember2'
        ]
    ]);

    echo $removeMembers->message;
    
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}