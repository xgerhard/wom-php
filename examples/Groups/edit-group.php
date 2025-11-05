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

    // https://docs.wiseoldman.net/api/groups/group-endpoints#edit-group
    $group = $client->groups->edit($groupId, [
        'verificationCode' => $verificationCode,
        'name' => 'My new clan name'
    ]);
    
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}