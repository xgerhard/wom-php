<?php

namespace WOM\Resources;

use WOM\Models\Player\Player;
use WOM\Enums\Efficiency\Metric;

class Efficiency extends BaseResource
{
    /**
     * Fetches the current efficiency rates for skills and bosses.
     *
     * @param string $metric
     * @return Player[] Array of Player models
     * @see https://docs.wiseoldman.net/efficiency-api/efficiency-endpoints#get-efficiency-rates
     */
    public function getGlobalLeaderboards(string $metric): array
    {
        if (!in_array($metric, Metric::all())) {
            throw new \InvalidArgumentException('Invalid metric: "'. $metric .'". Expected one of: ' . implode(', ', Metric::all()) .'.');
        }

        $response = $this->request('GET', 'efficiency/leaderboard', [
            'query' => ['metric' => $metric]
        ]);

        return $this->mapToModels($response, Player::class);
    }
}
