<?php

require('vendor/autoload.php');

use WOM\Enums\Boss;

try
{
    $client = new WOM\Client()
        ->setApiKey('--API-KEY-HERE--')
        ->setUserAgent('--USER-AGENT-HERE--');

    $groupId = 12345;
    $verificationCode = '111-222-333';

    $timezone = new DateTimeZone('Europe/Amsterdam'); // Timezones: https://www.php.net/manual/en/timezones.php
    $format = 'Y-m-d\TH:i:s.v\Z';

    // Start date examples
    $startDate = new DateTime('2025-11-10 09:00', $timezone);
    // $startDate = new DateTime('next monday', $timezone); // Or set a date like this: next monday

    // End date example, start date + week
    $endDate = clone $startDate;
    $endDate->modify('+7 days');

    // Convert times back to UTC to submit to WOM
    $startDate->setTimezone(new DateTimeZone('UTC'));
    $endDate->setTimezone(new DateTimeZone('UTC'));

    // https://docs.wiseoldman.net/api/competitions/competition-endpoints#create-competition
    $competition = $client->competitions->create([
        'title' => 'Skill of the week Slayer',
        'metric' => Skill::SLAYER, // Or for example: Boss::CHAMBERS_OF_XERIC
        'startsAt' => $startDate->format($format), // Or manually set the date here, for example: 2025-12-19T10:00:00.000Z
        'endsAt' =>  $endDate->format($format), // Same here, for example: 2025-12-26T10:00:00.000Z
        'groupId' => $groupId,
        'groupVerificationCode' => $verificationCode
    ]);

    if (isset($competition->competition->id)) {
        echo 'Competition created';
    } else {
        echo 'Failed to create competition';
    }
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}