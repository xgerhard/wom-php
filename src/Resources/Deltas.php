<?php

namespace WOM\Resources;

use WOM\Models\Delta\DeltaLeaderboardEntry;

class Deltas extends BaseResource
{
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

        return $this->mapToModels($response, DeltaLeaderboardEntry::class);
    }
}
