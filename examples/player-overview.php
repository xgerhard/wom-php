<?php

require('vendor/autoload.php');

$client = (new WOM\Client())
    ->setApiKey('--API-KEY-HERE--')
    ->setUserAgent('--USER-AGENT-HERE--');

$player = $client->players->get('gerhardoh');

echo $player->displayName;

echo '<hr>';
foreach ($player->latestSnapshot->data->skills as $skill) {
    if ($skill->isRanked()) {
        echo $skill->metricLabel() .': '. $skill->level .' ['. $skill->formattedExperience() .'] (#'. $skill->formattedRank() .')<br/>';
    }
}

echo '<hr>';
foreach ($player->latestSnapshot->data->bosses as $boss) {
    if ($boss->isRanked()) {
        echo $boss->metricLabel() .': '. $boss->kills .' (#'. $boss->formattedRank() .')<br/>';
    }
}

echo '<hr>';
foreach ($player->latestSnapshot->data->activities as $activity) {
    if ($activity->isRanked()) {
        echo $activity->metricLabel() .': '. $activity->score .' (#'. $activity->formattedRank() .')<br/>';
    }
}

echo '<hr>';
foreach ($player->latestSnapshot->data->computed as $computed) {
    if ($computed->isRanked()) {
        echo $computed->metricLabel() .': '. $computed->formattedValue() .' (#'. $computed->formattedRank() .')<br/>';
    }
}