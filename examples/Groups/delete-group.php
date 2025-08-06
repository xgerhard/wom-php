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

    // https://docs.wiseoldman.net/api/groups/group-endpoints#delete-group
    $deleteGroup = $client->groups->delete($groupId, $verificationCode);

    echo $deleteGroup->message;
    
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}