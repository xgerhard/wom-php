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
    /**
     * Search for players by partial username.
     *
     * @param array $params
     * @return Player[] Array of Player models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#search-players
     */
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

    /**
     * Tracks and updates a player. Returns a Details object with their latest snapshot.
     *
     * @param string $username
     * @return Details
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#update-a-player
     */
    public function update(string $username): Details
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('POST', 'players/' . urlencode($username));

        return new Details($response);
    }

    /**
     * Asserts a player's game mode type and updates it if incorrect. Returns the updated Player object and a flag indicating whether the type was changed.
     *
     * @param string $username
     * @return Player
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#assert-player-type
     */
    public function assertType(string $username): Player
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('POST', 'players/' . urlencode($username) . '/assert-type');

        return new Player($response);
    }

    /**
     * Fetches a player's details.
     *
     * @param string $username
     * @return Details
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-details
     */
    public function get(string $username): Details
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username));

        return new Details($response);
    }

    /**
     * Fetches a player's details by their ID.
     *
     * @param integer $id
     * @return Details
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-details-by-id
     */
    public function getById(int $id): Details
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Player ID is required.');
        }

        $response = $this->request('GET', 'players/id/' . $id);

        return new Details($response);
    }

    /**
     * Fetches a player's current achievements.
     *
     * @param string $username
     * @return Achievement[] Array of Achievement models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-achievements
     */
    public function getAchievements(string $username): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/achievements');

        return $this->mapToModels($response, Achievement::class);
    }

    /**
     * Fetches a player's current progress towards every possible achievement.
     *
     * @param string $username
     * @return AchievementProgress[] Array of AchievementProgress models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-achievement-progress
     */
    public function getAchievementProgress(string $username): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/achievements/progress');

        return $this->mapToModels($response, AchievementProgress::class);
    }

    /**
     * Fetches all of the player's competition participations.
     *
     * @param string $username
     * @param array $params
     * @return PlayerParticipation[] Array of PlayerParticipation models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-competition-participations
     */
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

    /**
     * Fetches all of the player's competition standings.
     *
     * @param string $username
     * @param array $params
     * @return PlayerStanding[] Array of PlayerStanding models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-competition-standings
     */
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

    /**
     * Fetches all of the player's group memberships
     *
     * @param string $username
     * @param array $params
     * @return PlayerMembership[] Array of PlayerMembership models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-group-memberships
     */
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

    /**
     * Fetches all of the player's gains for a specific period or time range.
     *
     * @param string $username
     * @param array $params
     * @return Gains
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-gains
     */
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

    /**
     * Fetches all of the player's records.
     *
     * @param string $username
     * @param array $params
     * @return Record[] Array of Record models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-records
     */
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

    /**
     * Fetches all of the player's past snapshots.
     *
     * @param string $username
     * @param array $params
     * @return Snapshot[] Array of Snapshot models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-snapshots
     */
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

    /**
     * Fetches all of the player's past snapshots (as a value/date timeseries array).
     *
     * @param string $username
     * @param array $params
     * @return TimelineDatapoint[] Array of TimelineDatapoint models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-snapshots-timeline
     */
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

    /**
     * Fetches all of the player's approved name changes.
     *
     * @param string $username
     * @return NameChange[] Array of NameChange models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-name-changes
     */
    public function getNameChanges(string $username): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/names');

        return $this->mapToModels($response, NameChange::class);
    }

    /**
     * Fetches all previous archived player profiles that held this username.
     *
     * @param string $username
     * @return Archive[] Array of Archive models
     * @see https://docs.wiseoldman.net/players-api/player-endpoints#get-player-archives
     */
    public function getArchives(string $username): array
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username is required.');
        }

        $response = $this->request('GET', 'players/' . urlencode($username) . '/archives');

        return $this->mapToModels($response, Archive::class);
    }
}
