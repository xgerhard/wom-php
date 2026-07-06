<?php

namespace WOM\Resources;

use WOM\Models\Efficiency\EfficiencyRate;
use WOM\Models\Player\Player;
use WOM\Enums\Efficiency\Metric;
use WOM\Enums\Efficiency\AlgorithmType;

class Efficiency extends BaseResource
{
    /**
     * Fetches the efficiency rates for a specific algorithm type and metric.
     *
     * @param array $params Required: type (AlgorithmType), metric (Efficiency\Metric: 'ehp' or 'ehb').
     * @return EfficiencyRate[] Array of EfficiencyRate models
     * @see https://docs.wiseoldman.net/api/efficiency/efficiency-endpoints#get-efficiency-rates
     */
    public function getRates(array $params = []): array
    {
        if (!isset($params['type'])) {
            throw new \InvalidArgumentException('The "type" parameter is required.');
        }

        if (!isset($params['metric'])) {
            throw new \InvalidArgumentException('The "metric" parameter is required.');
        }

        $response = $this->request('GET', 'efficiency/rates', [
            'query' => $params
        ]);

        return $this->mapToModels($response, EfficiencyRate::class);
    }

    /**
     * Fetches the current top efficiency leaderboard for a specific metric.
     *
     * @param array $params Required: metric (Efficiency\Metric or 'ehp+ehb'). Optional: playerType (PlayerType), playerBuild (PlayerBuild), country (Country), limit (int), offset (int).
     * @return Player[] Array of Player models
     * @see https://docs.wiseoldman.net/api/efficiency/efficiency-endpoints#get-global-efficiency-leaderboards
     */
    public function getGlobalLeaderboards(array $params = []): array
    {
        if (!isset($params['metric'])) {
            throw new \InvalidArgumentException('The "metric" parameter is required.');
        }

        $response = $this->request('GET', 'efficiency/leaderboard', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Player::class);
    }
}
