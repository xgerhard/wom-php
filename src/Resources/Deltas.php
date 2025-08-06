<?php

namespace WOM\Resources;

use WOM\Models\Delta\LeaderboardEntry;

class Deltas extends BaseResource
{
    /**
     * Fetches the current top deltas leaderboard for a specific metric and period.
     *
     * @param array $params
     * @return LeaderboardEntry[] Array of LeaderboardEntry models
     * @see https://docs.wiseoldman.net/api/deltas/delta-endpoints#get-global-delta-leaderboards
     */
    public function getGlobalLeaderboards(array $params = []): array
    {
        if (!isset($params['period'])) {
            throw new \InvalidArgumentException('Parameter period is required.');
        }

        if (!isset($params['metric'])) {
            throw new \InvalidArgumentException('Parameter metric is required.');
        }

        $response = $this->request('GET', 'deltas/leaderboard', [
            'query' => $params
        ]);

        return $this->mapToModels($response, LeaderboardEntry::class);
    }
}
