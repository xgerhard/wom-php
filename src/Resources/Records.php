<?php

namespace WOM\Resources;

use WOM\Models\Record\LeaderboardEntry;

class Records extends BaseResource
{
    /**
     * Fetches the current top records leaderboard for a specific metric and period.
     *
     * @param array $params Required: period (Period), metric (Metric). Optional: playerType (PlayerType), playerBuild (PlayerBuild), country (Country).
     * @return LeaderboardEntry[] Array of LeaderboardEntry models
     * @see https://docs.wiseoldman.net/api/records/record-endpoints#get-global-record-leaderboards
     */
    public function getGlobalLeaderboards(array $params = []): array
    {
        if (!isset($params['period'])) {
            throw new \InvalidArgumentException('Parameter period is required.');
        }

        if (!isset($params['metric'])) {
            throw new \InvalidArgumentException('Parameter metric is required.');
        }

        $response = $this->request('GET', 'records/leaderboard', [
            'query' => $params
        ]);

        return $this->mapToModels($response, LeaderboardEntry::class);
    }
}
