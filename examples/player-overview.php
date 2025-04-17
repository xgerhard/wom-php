<?php

require('vendor/autoload.php');

try
{
    $client = (new WOM\Client())
        ->setApiKey('--API-KEY-HERE--')
        ->setUserAgent('--USER-AGENT-HERE--');

    $player = $client->players->get('zezima');

    echo '<h1>'. $player->displayName .'</h1>';

    echo '<h3>Skills:</h3><hr>';
    foreach ($player->latestSnapshot->data->skills as $skill) {
        if ($skill->isRanked()) {
            echo $skill->formatMetric() .': '. $skill->level .' ['. $skill->formatExperience() .'] (#'. $skill->formatRank() .')<br/>';
        }
    }
    
    echo '<h3>Bosses:</h3><hr>';
    foreach ($player->latestSnapshot->data->bosses as $boss) {
        if ($boss->isRanked()) {
            echo $boss->formatMetric() .': '. $boss->kills .' (#'. $boss->formatRank() .')<br/>';
        }
    }
    
    echo '<h3>Activities:</h3><hr>';
    foreach ($player->latestSnapshot->data->activities as $activity) {
        if ($activity->isRanked()) {
            echo $activity->formatMetric() .': '. $activity->score .' (#'. $activity->formatRank() .')<br/>';
        }
    }
    
    echo '<h3>Computed metrics:</h3><hr>';
    foreach ($player->latestSnapshot->data->computed as $computed) {
        if ($computed->isRanked()) {
            echo $computed->formatMetric() .': '. $computed->formatValue() .' (#'. $computed->formatRank() .')<br/>';
        }
    }
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}