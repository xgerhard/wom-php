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

    // https://docs.wiseoldman.net/api/groups/group-endpoints#update-all-outdated-members
    $updateAll = $client->groups->updateAll($groupId, $verificationCode);

    echo $updateAll->message;
    
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}