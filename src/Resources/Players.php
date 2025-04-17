<?php

namespace WOM\Resources;

use WOM\Models\Competition\PlayerParticipation;
use WOM\Models\Group\PlayerMembership;
use WOM\Models\NameChange\NameChange;
use WOM\Models\Player\Achievement;
use WOM\Models\Player\AchievementProgress;
use WOM\Models\Player\Archive;
use WOM\Models\Player\Details;
use WOM\Models\Player\Gains;
use WOM\Models\Player\Player;
use WOM\Models\Player\PlayerStanding;
use WOM\Models\Player\Record;
use WOM\Models\Player\Snapshot;
use WOM\Models\Player\TimelineDatapoint;

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

    public function update(string $username): Details
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('POST', 'players/' . urlencode($username));

        return new Details($response);
    }

    public function assertType(string $username): Player
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('POST', 'players/' . urlencode($username) . '/assert-type');

        return new Player($response);
    }

    public function get(string $username): Details
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username));

        return new Details($response);
    }

    public function getById(int $id): Details
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Player ID is required.');
        }

        $response = $this->request('GET', 'players/id/' . $id);

        return new Details($response);
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

        return $this->mapToModels($response, PlayerStanding::class);
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

    public function getGains(string $username, array $params = []): Gains
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }
    
        $this->validateTimeParams($params);

        $response = $this->request('GET', 'players/' . urlencode($username) . '/gained', [
            'query' => $params
        ]);

        return new Gains($response);
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

        return $this->mapToModels($response, Archive::class);
    }
}
