<?php

namespace WOM\Resources;

use WOM\Models\Player\Achievement;
use WOM\Models\Player\AchievementProgress;
use WOM\Models\Player\Player;
use WOM\Models\Player\PlayerArchiveWithPlayer;
use WOM\Models\Player\PlayerCompetitionStanding;
use WOM\Models\Player\PlayerDetails;
use WOM\Models\Player\PlayerGains;
use WOM\Models\Player\PlayerMembership;
use WOM\Models\Player\PlayerParticipation;
use WOM\Models\Player\Record;
use WOM\Models\Player\Snapshot;
use WOM\Models\Player\TimelineDatapoint;
use WOM\Models\NameChange\NameChange;

class Players extends BaseResource
{
    public function search(array $params = []): array
    {
        if (!isset($params['username'])) {
            throw new \InvalidArgumentException('Search requires a username.');
        }

        $response = $this->request('GET', 'players/search', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Player::class);
    }

    public function update(string $username): PlayerDetails
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('POST', 'players/' . urlencode($username));

        return new PlayerDetails($response);
    }

    public function assertType(string $username): Player
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('POST', 'players/' . urlencode($username) . '/assert-type');

        return new Player($response);
    }

    public function get(string $username): PlayerDetails
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username));

        return new PlayerDetails($response);
    }

    public function getById(int $id): PlayerDetails
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Player ID is required.');
        }

        $response = $this->request('GET', 'players/id/' . $id);

        return new PlayerDetails($response);
    }

    public function getAchievements(string $username): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/achievements');

        return $this->mapToModels($response, Achievement::class);
    }

    public function getAchievementProgress(string $username): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/achievements/progress');

        return $this->mapToModels($response, AchievementProgress::class);
    }

    public function getCompetitionParticipations(string $username, array $params = []): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/competitions', [
            'query' => $params
        ]);
        return $this->mapToModels($response, PlayerParticipation::class);
    }

    public function getCompetitionStandings(string $username, array $params = []): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        if (!isset($params['status'])) {
            throw new \InvalidArgumentException('Parameter status is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/competitions/standings', [
            'query' => $params
        ]);

        return $this->mapToModels($response, PlayerCompetitionStanding::class);
    }

    public function getGroupMemberships(string $username, array $params = []): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/groups', [
            'query' => $params
        ]);

        return $this->mapToModels($response, PlayerMembership::class);
    }

    public function getGains(string $username, array $params = []): PlayerGains
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }
    
        $this->validateTimeParams($params);

        $response = $this->request('GET', 'players/' . urlencode($username) . '/gained', [
            'query' => $params
        ]);

        return new PlayerGains($response);
    }

    public function getRecords(string $username, array $params = []): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/records', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Record::class);
    }

    public function getSnapshots(string $username, array $params = []): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $this->validateTimeParams($params);

        $response = $this->request('GET', 'players/' . urlencode($username) . '/snapshots', [
            'query' => $params
        ]);

        return $this->mapToModels($response, Snapshot::class);
    }

    public function getSnapshotsTimeline(string $username, array $params = []): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        if (!isset($params['metric'])) {
            throw new \InvalidArgumentException('Parameter metric is required.');
        }

        $this->validateTimeParams($params);

        $response = $this->request('GET', 'players/' . urlencode($username) . '/snapshots/timeline', [
            'query' => $params
        ]);

        return $this->mapToModels($response, TimelineDatapoint::class);
    }

    public function getNameChanges(string $username): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/names');

        return $this->mapToModels($response, NameChange::class);
    }

    public function getArchives(string $username): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/archives');

        return $this->mapToModels($response, PlayerArchiveWithPlayer::class);
    }

    private function validateTimeParams(array $params): void
    {
        $hasPeriod = isset($params['period']);
        $hasStart = isset($params['startDate']);
        $hasEnd = isset($params['endDate']);
    
        if (!$hasPeriod && !($hasStart && $hasEnd)) {
            throw new \InvalidArgumentException('You must provide either "period" or both "startDate" and "endDate".');
        }
    
        if ($hasPeriod && ($hasStart || $hasEnd)) {
            throw new \InvalidArgumentException('Use either "period" or "startDate" and "endDate", not both.');
        }
    
        if ($hasStart xor $hasEnd) {
            throw new \InvalidArgumentException('You must provide both "startDate" and "endDate" together.');
        }
    }
}
